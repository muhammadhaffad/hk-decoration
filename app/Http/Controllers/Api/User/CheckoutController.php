<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource as CartCartResource;
use App\Http\Resources\CartResource;
use App\Http\Resources\Checkout\CheckoutResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Bank;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Shipping;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $checkout = Checkout::where('user_id', auth()->user()->id)->first();
        if ($checkout) {
            return new CheckoutResource($checkout);
        }
        return response(['message' => 'item kosong'], 404);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'array|min:1|required',
            'nama' => 'required',
            'notlp' => 'required',
            'tglsewa' => 'required|date|after:' . date('Y-m-d', strtotime("+ 1 day")) . '|date_format:Y-m-d',
            'tglbongkar' => 'required|date|after_or_equal:tglsewa|date_format:Y-m-d',
            'ongkir' => 'required',
            'alamat' => 'required',
            'bayar' => 'required|in:Lunas,Uang muka',
            'waktuPelunasan' => 'required_if:bayar,Uang muka|in:awal,akhir'
        ]);

        $order = $request->post();
        $items = Cart::find($order['items']);
        foreach ($items as $item) {
            $cart = $item;
            $item = $item->cartable()->first();
            if (isset($item->jmldisewa)) {
                if (@$item->jmldisewa + $cart->kuantitas > $item->stok) {
                    $orderitems = $item->orders(); //$item->orders()->where('status', 'lunas'); <- ini dipakai untuk menampilkan daftar antrian
                    $checkCollision = $orderitems->whereDate('tglSewa', '<=', date("Y-m-d", strtotime($order['tglbongkar'] . ' + 2 days')))->whereDate('tglBongkar', '>=', date("Y-m-d", strtotime($order['tglsewa'] . ' - 2 days')))->get()->toArray();
                    if (!empty($checkCollision)) {
                        return response(['message' => 'tanggal sewa <strong>' . $item->nama . '</strong> bertabrakan'], 403);
                    }
                }
            }
        }
        $items = Cart::find($data['items']);
        $startdate = strtotime($data['tglsewa']);
        $enddate = strtotime($data['tglbongkar']);
        $data['lamaSewa'] = ($enddate - $startdate) / 86400;
        $total = 0;
        foreach ($items as $idx => $item) {
            if ($item->cartable()->first()->harga >= 500000) {
                $data['hargaSewa'][$idx] = 100000;
                $total += $item->kuantitas * ($item->cartable()->first()->harga + ($data['lamaSewa'] * $data['hargaSewa'][$idx]));
            } else {
                $data['hargaSewa'][$idx] = $item->cartable()->first()->harga;
                $total += $item->kuantitas * ($item->cartable()->first()->harga + ($data['lamaSewa'] * $data['hargaSewa'][$idx]));
            }
        }
        if ($data['bayar'] === 'Uang muka') {
            $total = $total * 0.5;
        }
        $data['total'] = $total;
        $biayaongkir = Shipping::find($data['ongkir'])->harga;
        $data['biayaongkir'] = $biayaongkir;

        $data['items'] = implode(",", $data['items']);
        $data['hargaSewa'] = implode(",", $data['hargaSewa']);
        $data['user_id'] = auth()->user()->id;
        Checkout::where('user_id', $data['user_id'])->delete();
        Checkout::create($data);
        return response(['message' => 'item berhasil ditambah'], 200);
    }

    public function update(Request $request)
    {
        $checkout = Checkout::where('user_id', auth()->user()->id)->first();
        if ($checkout) {
            $request->validate([
                'nama' => 'required',
                'notlp' => 'required',
                'tglsewa' => 'required|date|after:' . date('Y-m-d', strtotime("+ 1 day")) . '|date_format:Y-m-d',
                'tglbongkar' => 'required|date|after_or_equal:tglsewa|date_format:Y-m-d',
                'ongkir' => 'required',
                'alamat' => 'required'
            ]);
            $items = Cart::find(explode(',', $checkout->items));
            foreach ($items as $item) {
                $cart = $item;
                $item = $item->cartable()->first();
                if (isset($item->jmldisewa)) {
                    if (@$item->jmldisewa + $cart->kuantitas > $item->stok) {
                        $orderitems = $item->orders(); //$item->orders()->where('status', 'lunas'); <- ini dipakai untuk menampilkan daftar antrian
                        $checkCollision = $orderitems->whereDate('tglSewa', '<=', date("Y-m-d", strtotime($request->tglbongkar . ' + 2 days')))->whereDate('tglBongkar', '>=', date("Y-m-d", strtotime($request->tglsewa . ' - 2 days')))->get()->toArray();
                        if (!empty($checkCollision)) {
                            return response(['message' => 'tanggal sewa <strong>' . $item->nama . '</strong> bertabrakan'], 403);
                        }
                    }
                }
            }
            $items = Cart::find(explode(',', $checkout->items));
            $startdate = strtotime($request->tglsewa);
            $enddate = strtotime($request->tglbongkar);
            $checkout->lamaSewa = ($enddate - $startdate) / 86400;
            $hargaSewas = explode(',', $checkout->hargaSewa);
            $total = 0;
            foreach ($items as $idx => $item) {
                if ($item->cartable()->first()->harga >= 500000) {
                    $hargaSewas[$idx] = 100000;
                    $total += $item->kuantitas * ($item->cartable()->first()->harga + ($checkout->lamaSewa * $hargaSewas[$idx]));
                } else {
                    $hargaSewas[$idx] = $item->cartable()->first()->harga;
                    $total += $item->kuantitas * ($item->cartable()->first()->harga + ($checkout->lamaSewa * $hargaSewas[$idx]));
                }
            }
            $checkout->hargaSewa = implode(',', $hargaSewas);
            if ($checkout->bayar === 'Uang muka') {
                $total = $total * 0.5;
            }
            $checkout->total = $total;
            $checkout->nama = $request->nama;
            $checkout->notlp = $request->notlp;
            $checkout->tglsewa = $request->tglsewa;
            $checkout->tglbongkar = $request->tglbongkar;
            $checkout->ongkir = $request->ongkir;
            $checkout->alamat = $request->alamat;
            $biayaongkir = Shipping::find($checkout->ongkir);
            if ($biayaongkir) {
                $biayaongkir = $biayaongkir->harga;
            } else {
                $biayaongkir = 50000;
            }
            $checkout->biayaongkir = $biayaongkir;
            $checkout->save();
            return response(['message' => 'data berhasil diupdate'], 200);
        } else {
            return response(['message' => 'item kosong'], 404);
        }
    }
}
