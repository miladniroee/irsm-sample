<?php

namespace App\Http\Resources;

use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $thumbnail= $this->thumbnail ?? $this->images?->first();

        $thumbnailAlt = null;
        if ($thumbnail){
            $thumbnailAlt = $this->images()->whereNot('id',$thumbnail->id)->first();
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug'=> $this->slug,
            'excerpt' => $this->excerpt,
            'type' => $this->type,
            'sku' => $this->sku,
            'price' => $this->price,
            'featured' => $this->featured,
            'sale_price' => $this->sale_price,
            'average_rating' => $this->average_rating,
            'rating_count' => $this->rating_count,
            'view_count' => $this->view_count,
            'in_stock' => $this->in_stock,
            'brand' => $this->brand?->name,
            'variation_id' => $this->variations?->first()?->id,
            'thumbnail' => new ImageResource($thumbnail),
            'thumbnail_alt' => new ImageResource($thumbnailAlt),
            'attributes'=> ProductAttributeResource::collection($this->variationAttributes())
        ];
    }
}
