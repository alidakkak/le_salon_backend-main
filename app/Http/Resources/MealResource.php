<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
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
            'name' => [
                'ar' => $this->name_ar,
                'en' => $this->name
            ],
            'description' => [
                'ar' => $this->description_ar,
                'en' => $this->description
            ],
            'image' => asset($this->image),
            'price' => $this->price,
            'optionalIngredients' => OptionResource::collection($this->optionals)
        ];
    }
}
