<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class KavehNegar
{
    private string $receptor;
    private string $token1;
    private string $token2 = '';
    private string $token3 = '';
    private string $token10 = '';
    private string $token20 = '';
    private string $template;

    public function receptor(string $receptor): static
    {
        $this->receptor = $receptor;

        return $this;
    }


    public function token1(string $token): static
    {
        $this->token1 = $token;

        return $this;
    }

    public function token2(string $token): static
    {
        $this->token2 = $token;

        return $this;
    }

    public function token3(string $token): static
    {
        $this->token3 = $token;

        return $this;
    }

    public function token10(string $token): static
    {
        $this->token10 = $token;

        return $this;
    }

    public function token20(string $token): static
    {
        $this->token20 = $token;

        return $this;
    }

    public function template(string $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function send(): \Illuminate\Http\Client\Response
    {
        $Data = [
            'receptor' => $this->receptor,
            'token' => $this->token1,
            'token2' => $this->token2,
            'token3' => $this->token3,
            'token10' => $this->token10,
            'token20' => $this->token20,
            'template' => $this->template,
        ];

        return Http::get('https://api.kavenegar.com/v1/' . env('SMS_API_TOKEN') . '/verify/lookup.json', $Data);
    }
}
