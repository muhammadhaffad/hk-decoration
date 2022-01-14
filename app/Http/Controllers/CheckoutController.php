<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Shipping;
use Illuminate\Http\Request;

use App\Http\Controllers\TripayChannels;

class CheckoutController extends Controller
{
    public function view()
    {
        $channels = new TripayChannels;
        $channels = json_decode($channels->getChannels())->data;
        $checkout = Checkout::where('user_id', auth()->user()->id)->first();
        if ($checkout) {
            $items = Cart::find(explode(',', $checkout->items));
            if ($items->toArray()) {
                return view('checkout', [
                    'items' => $items,
                    'checkout' => $checkout,
                    'channels' => $channels
                ]);
            }
            return redirect('cart');
        }
        return redirect('cart');
    }

    public function checkout(Request $request)
    {
        // Validasi masukan
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
        $items = Cart::find($data['items']);

        // Cek tanggal tabrakan
        $this->__checkCollision($items, $data);
        
        // menghitng lama sewa
        $startdate = strtotime($data['tglsewa']);
        $enddate = strtotime($data['tglbongkar']);
        $data['lamaSewa'] = ($enddate - $startdate) / 86400;
        
        // jumlah total semua harga pesanan
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
        
        // jumlah yang harus dibayarkan
        if ($data['bayar'] === 'Uang muka') {
            $total = $total * 0.5;
        }
        $data['total'] = $total;
        $data['biayaongkir'] = Shipping::find($data['ongkir'])->harga;
        $data['items'] = implode(",", $data['items']);
        $data['hargaSewa'] = implode(",", $data['hargaSewa']);
        $data['user_id'] = auth()->user()->id;
        
        // memasukan pesanan ke table checkout
        Checkout::where('user_id', $data['user_id'])->delete();
        Checkout::create($data);
        return redirect('checkout');
    }

    public function checkoutUpdate(Request $request)
    {
        $checkout = Checkout::where('user_id', auth()->user()->id)->first();
        if (!$checkout) {
            return back();
        }
        
        // validasi input
        $data = $request->validate([
            'nama' => 'required',
            'notlp' => 'required',
            'tglsewa' => 'required|date|after:' . date('Y-m-d', strtotime("+ 1 day")) . '|date_format:Y-m-d',
            'tglbongkar' => 'required|date|after_or_equal:tglsewa|date_format:Y-m-d',
            'ongkir' => 'required',
            'alamat' => 'required'
        ]);
        $items = Cart::find(explode(',', $checkout->items));
        
        // check tanggal tabrakan
        $this->__checkCollision($items, $data);
        
        // menghitung lama sewa
        $startdate = strtotime($request->tglsewa);
        $enddate = strtotime($request->tglbongkar);
        $checkout->lamaSewa = ($enddate - $startdate) / 86400;
        
        // menghitung total harga semua pesanan
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
        
        // menghitung berapa harga yang harus dibayarkan
        $checkout->hargaSewa = implode(',', $hargaSewas);
        if ($checkout->bayar === 'Uang muka') {
            $total = $total * 0.5;
        }
        
        // mengupdate data checkout
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
        return back();
    }

    protected function __checkCollision($items, $data)
    {
        foreach ($items as $item) {
            $cart = $item;
            $item = $item->cartable()->first();
            if (isset($item->jmldisewa)) {
                if (@$item->jmldisewa + $cart->kuantitas > $item->stok) {
                    $orderitems = $item->orders(); //$item->orders()->where('status', 'lunas'); <- ini dipakai untuk menampilkan daftar antrian
                    $checkCollision = $orderitems->whereDate('tglSewa', '<=', date("Y-m-d", strtotime($data['tglbongkar'] . ' + 2 days')))->whereDate('tglBongkar', '>=', date("Y-m-d", strtotime($data['tglsewa'] . ' - 2 days')))->get()->toArray();
                    if (!empty($checkCollision)) {
                        return back()->with('warning', 'Tanggal sewa <strong>' . $item->nama . '</strong> bertabrakan');
                    }
                }
            }
        }
    }
}
