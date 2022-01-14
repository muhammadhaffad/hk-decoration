<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function view(Request $request) {
        $carts = new Cart;
        $carts = $carts->where('user_id', Auth::user()->id);
        return view('cart', [
            'carts' => $carts
        ]);
    }

    public function increaseQty($id) {
        $carts = User::find(Auth::user()->id)->carts(); //1 diganti dengan Auth::user()->id;
        $item = $carts->find($id);
        if ($item->kuantitas+1 <= ($item->cartable()->first()->stok)) {
            $item->kuantitas = $item->kuantitas + 1;
            $item->save();
        }
        return back();
    }

    public function decreaseQty($id) {
        $carts = User::find(Auth::user()->id)->carts(); //1 diganti dengan Auth::user()->id;
        $item = $carts->find($id);
        if ($item->kuantitas - 1 > 0) {
            $item->kuantitas = $item->kuantitas - 1;
            $item->save();
        }
        return back();
    }

    public function remove($id) {
        $carts = User::find(Auth::user()->id)->carts(); //1 diganti dengan Auth::user()->id;
        $item = $carts->find($id);
        $item->delete();
    }

}
