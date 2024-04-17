<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
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
            'sale_price' => $this->sale_price,
            'sku' => $this->sku,
            'in_stock' => $this->in_stock,
            'stock_quantity' => $this->stock_quantity,
            'featured' => $this->featured,
            'barcode' => $this->barcode,
            'images' => ImageResource::collection($this->images),
            'attributes' => AttributeResource::collection($this->attributes),
        ];
    }
}
