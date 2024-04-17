<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'author_name' => $this->author_name,
            'author_url' => $this->author_url,
            'rating' => $this->rating,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'children' => CommentResource::collection($this->children),
        ];
    }
}
