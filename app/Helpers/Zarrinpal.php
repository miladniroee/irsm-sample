<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Http;
use SoapClient;
use SoapFault;

class Zarrinpal
{

    private bool $zarinGate = false;

    private bool $sandBox = true;

    private string $callback;

    private string $description;

    private float $amount;

    private string $email = '';

    private string $mobile;

    private string $authority;

    private array $errorMessages = [
        "-1" => "اطلاعات ارسال شده ناقص است.",
        "-2" => "IP و يا مرچنت كد پذيرنده صحيح نيست",
        "-3" => "با توجه به محدوديت هاي شاپرك امكان پرداخت با رقم درخواست شده ميسر نمي باشد",
        "-4" => "سطح تاييد پذيرنده پايين تر از سطح نقره اي است.",
        "-11" => "درخواست مورد نظر يافت نشد.",
        "-12" => "امكان ويرايش درخواست ميسر نمي باشد.",
        "-21" => "هيچ نوع عمليات مالي براي اين تراكنش يافت نشد",
        "-22" => "تراكنش نا موفق ميباشد",
        "-33" => "رقم تراكنش با رقم پرداخت شده مطابقت ندارد",
        "-34" => "سقف تقسيم تراكنش از لحاظ تعداد يا رقم عبور نموده است",
        "-40" => "اجازه دسترسي به متد مربوطه وجود ندارد.",
        "-41" => "اطلاعات ارسال شده مربوط به AdditionalData غيرمعتبر ميباشد.",
        "-42" => "مدت زمان معتبر طول عمر شناسه پرداخت بايد بين 30 دقيه تا 45 روز مي باشد.",
        "-54" => "درخواست مورد نظر آرشيو شده است",
        "100" => "عمليات با موفقيت انجام گرديده است.",
        "101" => "عمليات پرداخت موفق بوده و قبلا PaymentVerification تراكنش انجام شده است.",
    ];


    public function callback($value): static
    {
        $this->callback = $value;
        return $this;
    }

    public function description($value): static
    {
        $this->description = $value;
        return $this;
    }

    public function amount($value): static
    {
        $this->amount = $value;
        return $this;
    }

    public function mobile($value): static
    {
        $this->mobile = $value;
        return $this;
    }

    public function email($value): static
    {
        $this->email = $value;
        return $this;
    }

    public function authority($value): static
    {
        $this->authority = $value;
        return $this;
    }

    public function GetValues(): void
    {
        $this->sandBox = env('ZARRINPAL_SANDBOX', true);
        $this->zarinGate = env('ZARRINPAL_GATE', false);
        if (env('ZARRINPAL_CURRENCY', 'IRT') === "IRR") {
            $this->amount = ceil($this->amount / 10);
        }
    }


    private function error_message($code): string
    {

        if (array_key_exists("{$code}", $this->errorMessages)) {
            return $this->errorMessages["{$code}"];
        } else {
            return "خطای نامشخص هنگام اتصال به درگاه پرداخت";
        }
    }

    private static function zarrinpal_node(): string
    {
        $ir_ch = Http::get('https://www.zarinpal.com/pg/services/WebGate/wsdl');
        $de_ch = Http::get('https://de.zarinpal.com/pg/services/WebGate/wsdl');

        $ir_total_time = (isset($ir_ch->handlerStats()['total_time']) && $ir_ch->handlerStats()['total_time'] > 0) ? $ir_ch->handlerStats()['total_time'] : false;
        $de_total_time = (isset($de_ch->handlerStats()['total_time']) && $de_ch->handlerStats()['total_time'] > 0) ? $de_ch->handlerStats()['total_time'] : false;

        return ($ir_total_time === false || $ir_total_time > $de_total_time) ? "de" : "ir";
    }

    /**
     * @throws Exception
     */
    private function CheckRequestValues(): void
    {
        if (empty($this->callback)) {
            throw new Exception("لینک بازگشت ( CallbackURL ) نباید خالی باشد");
        }
        if (empty($this->description)) {
            throw new Exception("توضیحات تراکنش ( Description ) نباید خالی باشد");
        }
        if (empty($this->amount)) {
            throw new Exception("مبلغ تراکنش ( Amount ) نباید خالی باشد");
        }
        if (empty($this->mobile)) {
            throw new Exception("شماره موبایل خریدار ( Mobile ) نباید خالی باشد");
        }
    }

    /**
     * @throws Exception
     */
    private function CheckVerifyValues(): void
    {
        if (empty($this->amount)) {
            throw new Exception("مبلغ تراکنش ( Amount ) نباید خالی باشد");
        }
        if (empty($this->authority)) {
            throw new Exception("Authority ( سریال تراکنش ) نباید خالی باشد");
        }
    }

    /**
     * @throws SoapFault
     * @throws Exception
     */
    public function request(): object
    {
        $this->CheckRequestValues();
        $this->GetValues();

        $ZarinGate = ($this->sandBox === true) ? false : $this->zarinGate;

        $node = ($this->sandBox === true) ? "sandbox" : $this->zarrinpal_node();
        $upay = ($this->sandBox === true) ? "sandbox" : "www";

        $client = new SoapClient("https://{$node}.zarinpal.com/pg/services/WebGate/wsdl", ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest([
            'MerchantID' => env('ZARRINPAL_MERCHANT_ID', ''),
            'Amount' => $this->amount,
            'Description' => $this->description,
            'CallbackURL' => $this->callback,
            'Mobile' => $this->mobile,
            'Email' => $this->email
        ]);


        $Status = (isset($result->Status) && $result->Status != "") ? $result->Status : 0;
        $Authority = (isset($result->Authority) && $result->Authority != "") ? $result->Authority : "";
        $StartPay = (isset($result->Authority) && $result->Authority != "") ? "https://{$upay}.zarinpal.com/pg/StartPay/" . $Authority : "";
        $StartPayUrl = ($ZarinGate === true) ? "{$StartPay}/ZarinGate" : $StartPay;

        return (object)[
            "Node" => "{$node}",
            "Status" => $Status,
            "Message" => $this->error_message($Status),
            "StartPay" => $StartPayUrl,
            "Authority" => $Authority
        ];
    }


    /**
     * @throws SoapFault
     * @throws Exception
     */
    public function verify(): object
    {
        $this->CheckVerifyValues();
        $this->GetValues();

        $node = ($this->sandBox === true) ? "sandbox" : $this->zarrinpal_node();
        $client = new SoapClient("https://{$node}.zarinpal.com/pg/services/WebGate/wsdl", ['encoding' => 'UTF-8']);

        $result = $client->PaymentVerification([
            'MerchantID' => env('ZARRINPAL_MERCHANT_ID', ''),
            'Amount' => $this->amount,
            'Authority' => $this->authority,
        ]);

        $Status = (isset($result->Status) && $result->Status != "") ? $result->Status : 0;
        $RefID = (isset($result->RefID) && $result->RefID != "") ? $result->RefID : "";

        return (object)[
            "Node" => "{$node}",
            "Status" => $Status,
            "Message" => self::error_message($Status),
            "RefID" => $RefID,
            "Authority" => $this->authority
        ];
    }
}
