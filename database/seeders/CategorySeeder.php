<?php

namespace Database\Seeders;

use App\Enums\CategoryType;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!env('SEED_REAL_DATA')) {
            DB::table('categories')->insert([
                [
                    'id' => 1,
                    'name' => 'دسته بندی نشده',
                    'slug' => 'no-category-shop',
                    'parent_id' => NULL,
                    'description' => 'محصولات این بخش دسته بندی نشده اند.',
                    'image' => NULL,
                    'type' => CategoryType::Product,
                    'code' => NULL,
                    'updated_at' => now(),
                    'created_at' => now(),
                ],
                [
                    'id' => 2,
                    'name' => 'دسته بندی نشده',
                    'slug' => 'no-category-blog',
                    'parent_id' => NULL,
                    'description' => 'نوشته‌های این بخش دسته بندی نشده اند.',
                    'image' => NULL,
                    'type' => CategoryType::Post,
                    'code' => NULL,
                    'updated_at' => now(),
                    'created_at' => now(),
                ],
            ]);

            if (app()->isLocal()) {
                Category::factory()->count(50)->create();
            }
        } else {


            $categories = collect(\Nette\Utils\Json::decode(file_get_contents(database_path('json/categories.json'))));

            foreach ($categories as $category):
                \App\Models\Category::create([
                    'name' => $category->name,
                    'description' => $category->description,
                    'slug' => $category->slug,
                    'posts_count' => $category->count,
                    'type' => 'product',
                ]);
            endforeach;

            $children = $categories->filter(function ($cat) {
                return $cat->parent !== 0;
            });


            foreach ($children as $child):
                $parent = $categories->filter(function ($c) use ($child) {
                    return $c->term_id === $child->parent;
                });
                $thisOne = \App\Models\Category::whereSlug($child->slug)->first();

                $thisOne->parent_id = $parent->keys()->first() + 1;
                $thisOne->save();
            endforeach;
        }
    }
}
