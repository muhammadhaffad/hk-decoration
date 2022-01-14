<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request) {
        $order = Checkout::where('user_id', auth()->user()->id)->first();
        if ($order) {
            $items = Cart::find(explode(',',$order->items));
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
            $kode = 'HK' . strtoupper(Str::random(10));
            $payment = new Payment;
            if ($request->bukti != null) {
                $data = $request->validate([
                    'bukti' => 'required|image|file|max:1024'
                ]);
                $payment->tanggalKirim = date('Y-m-d H:i:s');
                $data['bukti'] = $request->file('bukti')->store('bukti-pembayaran');
                $payment->fotoBukti =  $data['bukti']; //ganti dengan upload bukti
                $payment->status = 'Belum dikonfirmasi';
            }
            $payment->save();
            $neworder = new Order;
            $neworder->user_id = auth()->user()->id; //Auth::user()->id;
            $neworder->payment_id = $payment->id;
            $neworder->kodeSewa = $kode;
            $neworder->tanggalTransaksi = date('Y-m-d H:i:s');
            $neworder->namaPenyewa = $order['nama'];
            $neworder->alamatPenyewa = $order['alamat'];
            $neworder->noTlpPenyewa = $order['notlp'];
            $neworder->tanggalSewa = $order['tglsewa'];
            $neworder->tanggalBongkar = $order['tglbongkar'];
            if ($order['bayar'] === 'Uang muka') {
                $neworder->jenis = 'DP';
                $neworder->waktuPelunasan = $order['waktuPelunasan'];
            } else {
                $neworder->jenis = 'Bayar lunas';
            }
            $neworder->total = $order['total'];
            $neworder->ongkir = $order['biayaongkir'];
            if ($request->bukti != null) {
                $neworder->status = 'sudah bayar';
            } else {
                $neworder->status = 'belum bayar';
            }
            $neworder->lamaSewa = $order['lamaSewa'];
            $neworder->save();

            $hargasewas = explode(',',$order['hargaSewa']);
            $items = Cart::find(explode(',',$order['items']));
            foreach ($items as $idx => $item) {
                $orderitem = new Orderitem;
                $orderitem->order_kodeSewa = $kode;
                $orderitem->kuantitas = $item->kuantitas;
                $orderitem->subtotal = $item->kuantitas*($item->cartable()->first()->harga + ($order['lamaSewa']*$hargasewas[$idx]));
                $orderitem->orderable_type = $item->cartable_type;
                $orderitem->orderable_id = $item->cartable_id;
                $orderitem->tglSewa = $order['tglsewa'];
                $orderitem->tglBongkar = $order['tglbongkar'];
                $orderitem->lamaSewa = $order['lamaSewa'];
                $orderitem->hargaSewa = $hargasewas[$idx];
                if ($request->bukti != null) {
                    $orderitem->status = 'sudah bayar';
                } else {
                    $orderitem->status = 'belum bayar';
                }
                $orderitem->save();
                if (isset($item->cartable()->first()->jmldisewa)) {
                    $decor = $item->cartable()->first();
                    $decor->jmldisewa += $item->kuantitas;
                    $decor->save();
                }
            }
            Cart::destroy(explode(',',$order['items']));
            $order->where('user_id', auth()->user()->id)->delete();
            return response(['message'=>'item berhasil dipesan'], 200);
        } else {
            return response(['message'=>'item kosong'], 404);
        }
    }

    public function index(Request $request) {
        if (isset($request->status) && $request->status  != 'belum bayar') {
            $payment = Payment::where('status', $request->status);
        } else if ($request->status  == 'belum bayar') {
            $payment = Payment::where('status', null);
        } else {
            $payment = new Payment;
        }
        $order = $payment->whereHas('order', function($q) {
            $q->where('user_id', auth()->user()->id);
        })->get();
        return OrderResource::collection($order);
    }

    public function uploadBukti(Request $request) {
        $data = $request->validate([
            'kodeSewa' => 'required',
            'bukti' => 'required|image|file|max:1024'
        ]);
        $data['bukti'] = $request->file('bukti')->store('bukti-pembayaran');
        $order = Order::where('user_id', auth()->user()->id);
        $order = $order->where('kodeSewa', $data['kodeSewa'])->first();
        $order->status = 'sudah bayar';
        $order->save();
        $payment = $order->payment()->first();
        $payment->tanggalKirim = date('Y-m-d H:i:s');
        $payment->fotoBukti = $data['bukti'];
        $payment->status = 'Belum dikonfirmasi';
        $payment->save();
        Orderitem::where('order_kodeSewa', $order->kodeSewa)->update(['status' => 'sudah bayar']);
        return response(['message'=>'bukti berhasil diupload'], 200);
    }
}
