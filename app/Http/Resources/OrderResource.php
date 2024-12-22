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
            'type' => 'order',
            'id' => $this->id,
            'attributes' => [
                'order_status' => $this->order_status->getLabel(),
                'payment_status' => $this->payment_status->getLabel(),
                'total' => $this->total,
                'items' => $this->when(
                    $request->routeIs('orders.show'),
                    OrderItemsResource::collection($this->orderItems)
                ),
            ]
        ];
    }
}
