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
            'type' => 'cart',
            'id' => $this->id,
            'attributes' => [
                'product' => $this->product->name,
                'quantity' => $this->quantity,
                'unit_price' => $this->unit_price
            ]
        ];
    }
}
