<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource as CartCartResource;
use App\Http\Resources\CartCollection;
use App\Http\Resources\CartResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Cart;
use App\Models\Decorationitem;
use App\Models\Decorationpacket;
use App\Models\Sessionpackage;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = auth()->user()->carts();
        return CartCartResource::collection($carts->get());
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'type' => 'required'
        ]);
        $item = null;
        $qty = 1;
        if (isset($request->qty) && @$request->qty > 0) {
            $qty = intval($request->qty);
        }
        if ($qty === 0) {
            $qty = 1;
        }
        if ($request->type == 'decorationitems') {
            $item = Decorationitem::find($id);
        } else if ($request->type == 'decorationpackets') {
            $item = Decorationpacket::find($id);
        } else if ($request->type == 'sessionpackages') {
            $item = Sessionpackage::find($id);
        } else {
            return response(['message' => 'type tidak sesuai'], 400);
        }
        if (isset($item->stok)) {
            if ($item->stok < $qty) {
                return response(['message' => 'Jumlah pemesanan melebihi batas'], 403);
            }
        }
        try {
            $item->carts()->create([
                'user_id' => auth()->user()->id, //1 diganti dengan Auth::user()->id nanti
                'kuantitas' => $qty,
            ]);
            return response(['message' => 'Item berhasil ditambahkan ke keranjang'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return response(['message' => 'Item sudah ditambahkan'], 403);
            }
        }
    }

    public function increaseQty($id)
    {
        $carts = auth()->user()->carts(); //1 diganti dengan Auth::user()->id;
        $item = $carts->find($id);
        if ($item->kuantitas + 1 <= ($item->cartable()->first()->stok)) {
            $item->kuantitas = $item->kuantitas + 1;
            $item->save();
        }
        return response(['message' => 'tambah item sukses'], 200);
    }

    public function decreaseQty($id)
    {
        $carts = auth()->user()->carts(); //1 diganti dengan Auth::user()->id;
        $item = $carts->find($id);
        if ($item->kuantitas - 1 > 0) {
            $item->kuantitas = $item->kuantitas - 1;
            $item->save();
        }
        return response(['message' => 'kurang item sukses'], 200);
    }

    public function destroy($id)
    {
        $carts = auth()->user()->carts(); //1 diganti dengan Auth::user()->id;
        $item = $carts->find($id);
        $item->delete();
        return response(['message' => 'item berhasil dihapus'], 200);
    }
}
