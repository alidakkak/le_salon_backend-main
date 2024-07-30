<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FloorResource extends JsonResource
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
                'ar' => $this->floor_name,
                'en' => $this->floor_name_ar,
            ],
//            'floor_name' => $this->floor_name,
//            'floor_name_ar' => $this->floor_name_ar,
            'tables' => TableResource::collection($this->tables)
        ];
    }
}
