<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    private bool $withAdminAttributes = false;

    public function withAdminAttributes(): self
    {
        $this->withAdminAttributes = true;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $adminAttributes = $this->withAdminAttributes ? $this->adminAttributes() : [];

        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'type' => $this->type,
            'excerpt' => $this->excerpt,
            'description' => $this->description,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'featured' => $this->featured,
            'in_stock' => $this->in_stock,
            'stock_quantity' => $this->stock_quantity,
            'view_count' => $this->view_count,
            'rating_count' => $this->rating_count,
            'average_rating' => $this->average_rating,
            'thumbnail' => $this->thumbnail?->path,
            'brand' => $this->getBrand($this->brand),
            'categories' => $this->getCategories($this->categories),
            'variations' => VariationResource::collection($this->variations),
            ...$adminAttributes,
            'comments' => route('product.comments', $this->slug),
        ];
    }

    private function getCategories($categories): array
    {
        $newCategories = [];
        foreach ($categories as $category):
            $newCategories[] = [
                'name' => $category->name,
                'slug' => $category->slug,
                'link' => route('shop.category', $category->slug),
            ];
        endforeach;

        return $newCategories;
    }

    private function getBrand($brand):array
    {
        return [
            'name' => $brand?->name,
            'slug' => $brand?->slug,
            'link' => route('shop.brand', $brand?->slug),
        ];

    }

    private function adminAttributes(): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'status' => $this->status,
            'in_stock' => $this->in_stock,
            'stock_quantity' => $this->stock_quantity,
            'total_sales' => $this->total_sales,
            'images' => ImageResource::collection($this->images),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
