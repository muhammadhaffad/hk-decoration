<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'item' => ProductResource::collection($this->orderable()->get()),
            'kuantitas' => $this->kuantitas,
            'subtotal' => $this->subtotal,
            'hargaSewa' => $this->hargaSewa
        ];
    }
}
