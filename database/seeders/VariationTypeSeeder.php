<?php

namespace Database\Seeders;

use App\Models\VariationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!env('SEED_REAL_DATA')) {
            $variationTypes = [
                [
                    'name' => 'Color',
                    'slug' => 'color',
                    'type' => 'color',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Size',
                    'slug' => 'size',
                    'type' => 'text',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Weight',
                    'slug' => 'weight',
                    'type' => 'text',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            VariationType::insert($variationTypes);
        } else {

            $variations = collect(\Nette\Utils\Json::decode(file_get_contents(database_path('json/variations.json'))));

            $types = $variations->pluck('taxonomy')->unique();
            $variationTypes = [];

            foreach ($types as $variation) {
                if ($variation == 'pa_جنس-تابلو') {
                    $variationTypes[] = [
                        'name' => 'جنس تابلو',
                        'slug' => 'tab_material',
                        'type' => 'text',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if ($variation == 'pa_size') {
                    $variationTypes[] = [
                        'name' => 'سایز',
                        'slug' => 'size',
                        'type' => 'text',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                if ($variation == 'pa_color') {
                    $variationTypes[] = [
                        'name' => 'رنگ',
                        'slug' => 'color',
                        'type' => 'color',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                if ($variation == 'pa_lenz') {
                    $variationTypes[] = [
                        'name' => 'لنز',
                        'slug' => 'lenz',
                        'type' => 'text',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            \App\Models\VariationType::insert($variationTypes);
        }
    }
}
