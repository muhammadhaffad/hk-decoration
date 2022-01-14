<?php

namespace App\Http\Resources\Checkout;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResource extends JsonResource
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
            'nama' => $this->nama,
            'notlp' => $this->notlp,
            'alamat' => $this->alamat,
            'tglsewa' => $this->tglsewa,
            'tglbongkar' => $this->tglbongkar,
            'bayar' => $this->bayar,
            'waktuPelunasan' => $this->waktuPelunasan,
            'ongkir' => $this->ongkir,
            'items' => null,
            'biayaongkir' => $this->biayaongkir,
            'total' => $this->total
        ];

        $this->hargaSewa = explode(',', $this->hargaSewa); 
        $carts = [];
        foreach (Cart::find(explode(',', $this->items)) as $idx => $cart) {
            $carts[] = [
                'id' => $cart->id,
                'nama' => $cart->cartable()->first()->nama,
                'gambar' => $cart->cartable()->first()->gambar,
                'harga' => $cart->cartable()->first()->harga,
                'kuantitas' => $cart->kuantitas,
                'lamaSewa' => $this->lamaSewa,
                'hargaSewa' => $this->hargaSewa[$idx],
                'subtotal' => $cart->kuantitas*($cart->cartable()->first()->harga+$this->lamaSewa*$cart->cartable()->first()->harga)
            ];
        }

        $data['items'] = new Collection($carts);
        return $data;
    }
}
