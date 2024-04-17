<?php

namespace Database\Seeders;

use App\Enums\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            [
                'name' => 'نقدی',
                'value' => 'cash',
            ],
            [
                'name' => 'کارت به کارت',
                'value' => 'to_card',
            ],
            [
                'name' => 'کارتخوان',
                'value' => 'p.o.s',
            ],
            [
                'name' => 'زرین پال',
                'value' => 'zarrinpal',
            ],
        ]);
    }
}
