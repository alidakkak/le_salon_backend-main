<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'table_id' => $this->table_id,
            'table' => TableResource::make($this->table),
            'total' => $this->total,
            'order_state' => $this->order_state,
            'receipt_id' => $this->receipt_id,
            'order_items' => OrderItemsResource::collection($this->orderItems),
            'created_at' => $this->created_at->format('Y-M-D h:i a')
        ];
    }
}
