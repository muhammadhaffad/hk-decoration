<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Decorationitem;
use App\Models\Decorationpacket;
use App\Models\Sessionpackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\all;

class DecorationController extends Controller
{
    public function view(Request $request)
    {
        $decorations = null;
        $additionItem = false;
        if ($request->category === 'all' || !isset($request->category)) {
            $decorations = new Decorationpacket;
        } else if ($request->category === 'item tambahan') {
            $decorations = new Decorationitem;
            $additionItem = true;
        } else {
            $category = Category::whereIn('nama', [$request->category]);
            $decorations = $category->first()->decorationpackets();
        }
        $decorations = $decorations->orderBy('id', 'desc')->paginate(16)->withQueryString();
        return view('decoration', [
            'decorations' => $decorations,
            'additionItem' => $additionItem,
            'categories' => Category::all(),
        ]);
    }

    public function show(Request $request, $id)
    {
        $decorations = null;
        $additionItem = false;
        if ($request->category === 'all' || !isset($request->category)) {
            $decorations = new Decorationpacket;
        } else if ($request->category === 'item tambahan') {
            $decorations = new Decorationitem;
            $additionItem = true;
        } else {
            $category = Category::whereIn('nama', [$request->category]);
            $decorations = $category->first()->decorationpackets();
        }
        $decorations = $decorations->orderBy('id', 'desc')->paginate(16)->withQueryString();
        return view('decoration-view', [
            'decorations' => $decorations,
            'additionItem' => $additionItem,
            'categories' => Category::all(),
        ]);
    }

    public function addToCart(Request $request, $id)
    {
        $decoration = null;
        $qty = 1;
        if (isset($request->qty) && @$request->qty > 0) {
            $qty = intval($request->qty);
        }
        if ($qty === 0) {
            $qty = 1;
        }
        if ($request->additionitem == 'true') {
            $decoration = Decorationitem::find($id);
        } else {
            $decoration = Decorationpacket::find($id);
        }
        if ($decoration->stok < $qty) {
            return back()->with('warning', 'Stok item sudah habis');
        }
        try {
            $decoration->carts()->create([
                'user_id' => Auth::user()->id, //1 diganti dengan Auth::user()->id nanti
                'kuantitas' => $qty,
            ]);
            return back()->with('success', 'Item berhasil ditambahkan ke keranjang');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return back()->with('warning', 'Item sudah masuk di keranjang');
            }
        }
    }
}
