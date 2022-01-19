<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TripayTransaction;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'nullable|in:unpaid,paid,expired,failed,refund'
        ]);
        $status = 'unpaid';
        if ($request->status) {
            $status = $request->status;
        }
        $orders = Order::where('status', $status);
        $orders = $orders->where('user_id', Auth::user()->id)->orderBy('status', 'asc')->orderBy('id', 'desc'); //1 diganti dengan Auth::user()->id
        return view('myorder', [
            'orders' => $orders,
            'status' => $status
        ]);
    }

    public function show($code) 
    {
        $order = Order::where('user_id', auth()->user()->id);
        $order = $order->with(['orderitems'])->where('kodeSewa', $code)->first();
        // lihat detail transaksi di tripay
        $transaction = new TripayTransaction();
        $transaction = $transaction->detailTransaction($code);
        return view('myorder-view', [
            'order' => $order,
            'transaction' => $transaction
        ]);
    }

    public function order(Request $request)
    {
        // validasi input
        $request->validate([
            'method' => 'required',
            'bayar' => 'required'
        ]);
        // cek data di table checkout
        $order = Checkout::where('user_id', auth()->user()->id)->first();
        if (!$order) {
            return back();
        }
        // get data dari table cart berdasarkan kolom items di table checkout
        $items = Cart::find(explode(',', $order->items));

        $this->__checkCollision($items, $order);

        // request transaksi ke web tripay
        $transaction = new TripayTransaction();
        $transaction = $transaction->transaction($order, $request->method, $items, $order->bayar);
        // cek request transaksi berhasil atau tidak
        if (!$transaction->success) {
           return back(); 
        }

        // input ke database
        $kode = $transaction->data->reference;
        $neworder = new Order;
        $neworder->user_id = Auth::user()->id; //Auth::user()->id;
        $neworder->kodeSewa = $kode;
        $neworder->tanggalTransaksi = date('Y-m-d H:i:s');
        $neworder->namaPenyewa = $order->nama;
        $neworder->alamatPenyewa = $order->alamat;
        $neworder->noTlpPenyewa = $order->notlp;
        $neworder->tanggalSewa = $order->tglsewa;
        $neworder->tanggalBongkar = $order->tglbongkar;
        if ($order->bayar === 'Uang muka') {
            $neworder->jenis = 'DP';
            $neworder->waktuPelunasan = $order->waktuPelunasan;
        } else {
            $neworder->jenis = 'Bayar lunas';
        }
        $neworder->total = $transaction->data->amount;
        $neworder->ongkir = $order->biayaongkir;
        $neworder->lamaSewa = $order->lamaSewa;
        $neworder->metodeBayar = $request->method;
        $neworder->biayaTransfer = $transaction->data->total_fee;
        $neworder->save();

        $hargasewas = explode(',', $order->hargaSewa);
        $items = Cart::find(explode(',', $order->items));
        foreach ($items as $idx => $item) {
            $orderitem = new Orderitem;
            $orderitem->order_kodeSewa = $kode;
            $orderitem->kuantitas = $item->kuantitas;
            $orderitem->subtotal = $item->kuantitas * ($item->cartable()->first()->harga + ($order->lamaSewa * $hargasewas[$idx]));
            $orderitem->orderable_type = $item->cartable_type;
            $orderitem->orderable_id = $item->cartable_id;
            $orderitem->tglSewa = $order->tglsewa;
            $orderitem->tglBongkar = $order->tglbongkar;
            $orderitem->lamaSewa = $order->lamaSewa;
            $orderitem->hargaSewa = $hargasewas[$idx];
            $orderitem->save();
            if (isset($item->cartable()->first()->jmldisewa)) {
                $decor = $item->cartable()->first();
                $decor->jmldisewa += $item->kuantitas;
                $decor->save();
            }
        }
        Cart::destroy(explode(',', $order['items']));
        $order->where('user_id', auth()->user()->id)->delete();
        return redirect('myorder');
    }

    public function __checkCollision($items, $data)
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
