<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'category' => Category::find($this->category_id),
            'datetime' => $this->datetime,
        ];
    }
}
