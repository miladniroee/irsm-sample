<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'featured' => $this->featured,
            'sale_price' => $this->sale_price,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'images' => ImageResource::collection($this->images),
            'attributes' => ProductAttributeResource::collection($this->attributes),
        ];
    }
}
