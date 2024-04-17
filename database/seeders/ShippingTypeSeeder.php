<?php

namespace Database\Seeders;

use App\Models\ShippingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingTypeSeeder extends Seeder
{

    private array $shippingTypes = [
        [
            'name' => 'پست پیشتاز',
            'slug' => 'pishtaz',
            'is_active' => true,
        ],
        [
            'name' => 'پست ویژه',
            'slug' => 'vizheh',
            'is_active' => true,
        ],
        [
            'name' => 'تیپاکس',
            'slug' => 'tipax',
            'is_active' => false,
        ],
        [
            'name' => 'پیک',
            'slug' => 'peyk',
            'is_active' => true,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->shippingTypes as $shippingType):
            ShippingType::create($shippingType);
        endforeach;
    }
}
