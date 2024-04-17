<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!env('SEED_REAL_DATA')) {
            DB::table('brands')->insert([
                'id' => 1,
                'name' => 'بدون برند',
                'slug' => 'no-brand',
                'description' => 'بدون برند',
                'image' => NULL,
                'updated_at' => now(),
                'created_at' => now(),
            ]);

            if (app()->isLocal()) {
                Brand::factory()->count(10)->create();
            }
        } else {
            $brands = collect(\Nette\Utils\Json::decode(file_get_contents(database_path('json/brands.json'))));

            foreach ($brands as $brand):
                \App\Models\Brand::create([
                    'name' => $brand->name,
                    'slug' => $brand->slug,
                    'description' => empty($brand->description) ? NULL : $brand->description,
                    'products_count' => $brand->count
                ]);
            endforeach;
        }
    }
}
