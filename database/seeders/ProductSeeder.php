<?php

namespace Database\Seeders;

use App\Enums\ProductType;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Seeder;
use stdClass;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!env('SEED_REAL_DATA')) {


            $products = Product::factory()->count(100)->create();

            foreach ($products as $product) {
                $product->categories()->attach([1, 2, 3, 4, 5]);

                Comment::factory(rand(1, 5))->create([
                    'commentable_id' => $product->id,
                    'commentable_type' => Product::class,
                ]);

                Attachment::factory(rand(1, 5))->create([
                    'attachable_id' => $product->id,
                    'attachable_type' => Product::class,
                ]);

                if ($product->type === ProductType::Variable->value) {
                    $variations = ProductVariation::factory(rand(2, 5))->create([
                        'product_id' => $product->id,
                    ]);

                    foreach ($variations as $variation) {
                        $variation->attributes()->attach(range(1, rand(1, 3)));
                    }
                } else {
                    ProductVariation::factory(1)->create([
                        'product_id' => $product->id,
                        'price' => $product->price,
                        'sale_price' => $product->sale_price,
                        'stock_quantity' => $product->stock_quantity,
                        'in_stock' => $product->in_stock,
                    ]);
                }
            }
        } else {
            $this->realData();
        }

    }

    private function realData(): void
    {
        function userId($id)
        {
            $user = collect(\Nette\Utils\Json::decode(file_get_contents(database_path('json/users.json'))))
                ->filter(function ($item) use ($id) {
                    return $item->id === $id;
                });
            return $user->count() > 0 ? $user->keys()[0] + 1 : null;
        }

        function variation($id)
        {
            $user = collect(\Nette\Utils\Json::decode(file_get_contents(database_path('json/variations.json'))))
                ->filter(function ($item) use ($id) {
                    return $item->term_id === $id;
                });
            return $user->keys()[0] + 1;
        }

        $products = collect(\Nette\Utils\Json::decode(file_get_contents(database_path('json/products.json'))));

        foreach ($products as $key => $product):

            if ($product->post_title === 'AUTO-DRAFT') continue;

            $user = userId($product->post_author);
            $categories = \App\Models\Category::whereIn('slug', array_column($product->categories, 'slug'))->get();
            $brand = \App\Models\Brand::whereSlug($product->brand?->slug ?? 'no-brand')->first();

            $mainCategoryTermId = $product->main_category[0] ?? NULL;
            $mainCategory = NULL;
            if ($mainCategoryTermId):
                $mainCategory = collect($product->categories)->filter(function ($category) use ($mainCategoryTermId) {
                    return $category->term_id == $mainCategoryTermId;
                });
            endif;

            if (empty($product->product_meta->price ?? "")) {
                if (empty($product->product_meta->min_price ?? "")) {
                    if (empty($product->product_meta->max_price ?? "")) {
                        $price = 0;
                    } else {
                        $price = $product->product_meta->max_price;
                    }
                } else {
                    $price = $product->product_meta->min_price;
                }
            } else {
                $price = $product->product_meta->price;
            }

            $price = number_format($price, 2, '.', '');
            $status = match ($product->post_status) {
                'publish' => \App\Enums\ProductStatus::Published,
                'private' => \App\Enums\ProductStatus::Pending,
                default => \App\Enums\ProductStatus::Draft,
            };

            $deleted_at = match ($product->post_status) {
                'trash' => now(),
                default => NULL,
            };

            $type = !empty($product->variations) ? \App\Enums\ProductType::Variable : \App\Enums\ProductType::Fixed;


            $slug = $product->post_name;

            if ($slug == ''){
                $slug = \Illuminate\Support\Str::slug($product->post_title) . '-'.$product->post_status . $key;
            }

            while (\App\Models\Product::withoutGlobalScopes()->where('slug',$slug)->count() > 0){
                $slug .= $key;
            }


            $newProduct = \App\Models\Product::create([
                'name' => $product->post_title,
                'slug' => $slug,
                'type' => $type,
                'excerpt' => $product->post_excerpt,
                'description' => $product->post_content,
                'price' => $price,
                'sale_price' => $product->product_meta->sale_price ?? NULL,
                'featured' => $product->product_meta?->onsale ?? false,
                'in_stock' => $product->product_meta?->stock_status ?? NULL === 'instock',
                'stock_quantity' => $product->product_meta->stock_quantity ?? 0,
                'view_count' => $product->view ?? 0,
                'rating_count' => $product->product_meta->rating_count ?? 0,
                'average_rating' => $product->product_meta->rating_average ?? 0,
                'total_sales' => $product->product_meta->total_sales ?? 0,
                'status' => $status,
                'brand_id' => $brand->id ?? 1,
                'user_id' => $user,
                'updated_at' => \Illuminate\Support\Carbon::parse($product->post_modified)->format('Y-m-d H:i:d'),
                'created_at' => \Illuminate\Support\Carbon::parse($product->post_date)->format('Y-m-d H:i:d'),
                'deleted_at' => $deleted_at,
            ]);

            if ($categories->count() > 0):
                foreach ($categories as $category):
                    $category->products()->attach($newProduct->id, [], ['is_main' => $category->slug == $mainCategory?->first()?->slug]);
                endforeach;
            else:
                \App\Models\Category::find(1)->products()->attach($newProduct->id);
            endif;


            if (!empty($product->attachments)) {
                $att = [];
                foreach ($product->attachments as $attachment) {
                    if ($attachment instanceof stdClass) {
                        $att[] = new \App\Models\Attachment([
                            'name' => $attachment->post_title,
                            'type' => \App\Enums\AttachmentType::Image,
                            'path' => $attachment->guid,
                            'mime_type' => $attachment->post_mime_type,
                            'is_thumbnail' => $attachment->ID == (property_exists($product, 'thumbnail') ? $product->thumbnail : 0),
                        ]);
                    }
                }
                $newProduct->attachments()->saveMany($att);
            }

            if (!empty($product->comments)):
                $comments = [];
                foreach ($product->comments as $comment):

                    if ($comment->comment_type !== 'review') continue;
                    $user = userId($comment->user_id);
                    $comments[] = new \App\Models\Comment([
                        'user_id' => $user ?? NULL,
                        'author_name' => $comment->comment_author,
                        'author_email' => $comment->comment_author_email,
                        'author_url' => $comment->comment_author_url,
                        'author_ip' => $comment->comment_author_IP,
                        'body' => $comment->comment_content,
                        'rating' => $comment->meta->rating ?? NULL,
                        'is_approved' => $comment->comment_approved === '1',
                        'created_at' => \Illuminate\Support\Carbon::parse($comment->comment_date)->format('Y-m-d H:i:s'),
                        'updated_at' => \Illuminate\Support\Carbon::parse($comment->comment_date)->format('Y-m-d H:i:s'),
                        'deleted_at' => $comment->comment_approved === 'post-trashed' ? now() : NULL,
                    ]);

                endforeach;

                $newProduct->comments()->saveMany($comments);
            endif;

            $min_price = $price;
            $featured = $product->product_meta?->onsale ?? false;
            $min_sale_price = $product->product_meta->sale_price ?? NULL;
            foreach ($product->variations as $variation):

                if ($variation->post_type !== 'product_variation') continue;
                if (empty($variation->attributes)) continue;

//                if (!property_exists($variation->attributes,'_price')){
//                    dd($variation->attributes);
//                }

                if (empty($variation->product_meta->price ?? "")) {
                    if (empty($variation->product_meta->min_price ?? "")) {
                        if (empty($variation->product_meta->max_price ?? "")) {
                            $alt_price = 0;
                        } else {
                            $alt_price = $variation->product_meta->max_price;
                        }
                    } else {
                        $alt_price = $variation->product_meta->min_price;
                    }
                } else {
                    $alt_price = $variation->product_meta->price;
                }

                $sale_price = $variation->product_meta->onsale ? $variation->attributes->_price : null;
                $price = $variation->attributes->_regular_price ?? $variation->attributes->_price ?? $alt_price;

                $price = number_format((float)$price, 2, '.', '');

                if ($min_price > $price) {
                    $min_price = $price;
                }

                if ($variation->product_meta->onsale){
                    $featured = true;

                    if ($min_sale_price > $sale_price){
                        $min_sale_price = $sale_price;
                    }
                }



                $newVariation = $newProduct->variations()->create([
                    'price' => $price,
                    'sale_price' => $sale_price,
                    'sku' => empty($variation->product_meta->sku) ? NULL : $variation->product_meta->sku,
                    'stock_quantity' => ($variation->product_meta->stock_quantity ?? 0) < 0 ? 0 : $variation->product_meta->stock_quantity ?? 0,
                    'in_stock' => $variation->product_meta->stock_status === 'instock',
                    'featured' => $variation->product_meta->onsale,
                    'total_sales' => $variation->product_meta->total_sales ?? 0,
                    'store_id' => \App\Models\Store::where('user_id', $user)->first()?->id ?? 17,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);

                $thumbnailId = $variation->attributes->_thumbnail_id ?? null;
                if ($thumbnailId) {
                    $thumbnail = collect($product->attachments)->filter(function ($attachment) use ($thumbnailId, $newVariation) {
                        return $attachment->ID == $thumbnailId;
                    })->first()?->guid ?? null;

                    if ($thumbnail) {
                        $image = \App\Models\Attachment::wherePath($thumbnail)->first();

                        if ($image) {
                            $newVariation->attachments()->save($image);
                        }
                    }
                }


                foreach ($variation->product_meta->terms as $term):
                    $variationid = null;
                    try {
                        $variationid = variation($term->term_id);
                    } catch (\Exception $e) {
                    }
                    if ($variationid) {


                        \App\Models\ProductAttributes::create([
                            'variation_id' => variation($term->term_id),
                            'product_variation_id' => $newVariation->id
                        ]);
                    }
                endforeach;

            endforeach;

            if ($newProduct->variations->count() === 0) {
                $newProduct->variations()->create([
                    'price' => $price,
                    'sale_price' => $product->product_meta->sale_price ?? NULL,
                    'featured' => $product->product_meta?->onsale ?? false,
                    'in_stock' => $product->product_meta?->stock_status ?? NULL === 'instock',
                    'sku' => empty($product->product_meta->sku) ? NULL : $product->product_meta->sku,
                    'stock_quantity' => $product->product_meta->stock_quantity ?? 0,
                    'total_sales' => $product->product_meta->total_sales ?? 0,
                    'store_id' => \App\Models\Store::where('user_id', $user)->first()?->id ?? 17,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);
            }

            $newProduct->update([
                'price' => $min_price,
                'sale_price' => $min_sale_price,
                'featured' => $featured,
            ]);

        endforeach;

        \App\Models\Product::withoutGlobalScope('publish')->get()->each(function ($product){
            $variations = $product->variations;
            $product->price = $variations->pluck('price')->unique()->flatten()->min();

            $sale_price = $variations->pluck('sale_price')->unique()->flatten()->min();

            $product->sale_price = $sale_price;
            $product->featured = !!$sale_price;

            $product->save();
        });

        \App\Models\Product::withoutGlobalScope('publish')->get()->each(function ($product){
            $stockQuantity = $product->variations->pluck('stock_quantity')->sum();
            $product->stock_quantity = $stockQuantity;
            $product->in_stock = $stockQuantity > 0;

            $product->save();
        });
    }
}
