<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'product' => [
                'id' => $this->variation->product->id,
                'name' => $this->variation->product->name,
                'slug' => $this->variation->product->slug,
                'type' => $this->variation->product->type,
                'variation' => [
                    'id' => $this->variation->id,
                    'price' => $this->variation->price,
                    'sale_price' => $this->variation->sale_price,
                    'featured' => $this->variation->featured,
                    'thumbnail' => new ImageResource($this->variation->images?->first()),
                    'attributes' => $this->variation->attributes->map(function ($attribute) {
                        return [
                            'name' => $attribute->type->name,
                            'value' => $attribute->name,
                        ];
                    }),
                ],
            ],
            'quantity' => $this->quantity,
            'total' => $this->total(),
        ];
    }
}
