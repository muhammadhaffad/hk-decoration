<?php

namespace App\Http\Resources\Order;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $order = $this->order()->first();
        $data = [
            'id' => $order->id,
            'user_id' => $order->user_id,
            'payment_id' => $order->payment_id,
            'kodeSewa' => $order->kodeSewa,
            'tanggalTransaksi' => $order->tanggalTransaksi,
            'namaPenyewa' => $order->namaPenyewa,
            'alamatPenyewa' => $order->alamatPenyewa,
            'noTlpPenyewa' => $order->noTlpPenyewa,
            'tanggalSewa' => $order->tanggalSewa,
            'tanggalBongkar' => $order->tanggalBongkar,
            'lamaSewa' => $order->lamaSewa,
            'tanggalKembali' => $order->tanggalKembali,
            'jenis' => $order->jenis,
            'waktuPelunasan' => $order->waktuPelunasan,
            'total' => $order->total,
            'ongkir' => $order->ongkir,
            'status' => $this->status,
            'orderitems' => OrderItemResource::collection($order->orderitems()->get()),
        ];

        return $data;
    }
}
