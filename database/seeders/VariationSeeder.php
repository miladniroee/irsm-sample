<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariationSeeder extends Seeder
{

    private array $variations = [
        [
            'variation_type_id' => 2,
            'name' => 'large',
            'slug' => 'large',
            'options' => null,
        ],
        [
            'variation_type_id' => 2,
            'name' => 'medium',
            'slug' => 'medium',
            'options' => null,
        ],
        [
            'variation_type_id' => 2,
            'name' => 'small',
            'slug' => 'small',
            'options' => null,
        ],
        [
            'variation_type_id' => 1,
            'name' => 'green',
            'slug' => 'green',
            'options' => [
                'color' => '#00ff00'
            ],
        ],
        [
            'variation_type_id' => 1,
            'name' => 'red',
            'slug' => 'red',
            'options' => [
                'color' => '#ff0000'
            ],
        ],
        [
            'variation_type_id' => 1,
            'name' => 'blue',
            'slug' => 'blue',
            'options' => [
                'color' => '#0000ff'
            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!env('SEED_REAL_DATA')) {
            foreach ($this->variations as $variation) {
                \App\Models\Variation::create($variation);
            }
        } else {
            $variations = collect(\Nette\Utils\Json::decode(file_get_contents(database_path('json/variations.json'))));

            foreach ($variations as $variation) {

                $option = NULL;

                if (!empty($variation->mwebshop_product_attribute_color) || !empty($variation->product_pa_color)) {
                    if (str_starts_with($variation->mwebshop_product_attribute_color ?? $variation->product_pa_color, '#'))
                        $option = ['attribute_color' => $variation->mwebshop_product_attribute_color ?? $variation->product_pa_color];
                }


                $type = match ($variation->taxonomy) {
                    'pa_جنس-تابلو' => 4,
                    'pa_size' => 1,
                    'pa_color' => 2,
                    'pa_lenz' => 3
                };


                $hasValue = \App\Models\Variation::whereSlug($variation->slug)->count();

                if ($hasValue == 0) {
                    $slug = $variation->slug;
                } else {
                    $slug = $variation->slug . '-' . $variation->taxonomy;
                }

                \App\Models\Variation::create([
                    'name' => $variation->name,
                    'slug' => $slug,
                    'variation_type_id' => $type,
                    'options' => $option,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);
            }
        }
    }
}
