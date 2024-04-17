<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'city' => $this->city,
            'state' => $this->state,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'zip_code' => $this->zip_code,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'company' => $this->company,
        ];
    }
}
