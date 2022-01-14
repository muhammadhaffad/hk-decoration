<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'item' => new CartItemResource($this->cartable()->first()),
            'kuantitas' => $this->kuantitas,
            'totalHarga' => $this->cartable()->first()->harga*$this->kuantitas
        ];
        return $data;
    }
}
