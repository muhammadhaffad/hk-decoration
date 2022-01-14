<?php

namespace App\Http\Controllers;

use App\Models\Decorationpacket;
use Illuminate\Http\Request;

class DecorationpacketController extends Controller
{
    public function show($id)
    {
        $decoration = Decorationpacket::find($id);
        return view('decoration-view', [
            'decoration' => $decoration
        ]);
    }

    public function addReview(Request $request, $id)
    {
        $d = Decorationpacket::find($id);
        $data = $request->validate([
            'judul' => 'required|min:3|max:100',
            'rating' => 'required|min:0|max:5|numeric',
            'gambar' => 'nullable|file|image|max:1024',
            'isi' => 'required|min:3|max:1500'
        ]);
        $data['user_id'] = auth()->user()->id;
        if ($request->file('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('testimonial-images');
        }
        $d->testimonials()->create($data);
        return back();
    }

    public function addToCart(Request $request, $id)
    {
        $qty = 1;
        if (isset($request->qty) && @$request->qty > 0) {
            $qty = intval($request->qty);
        }
        if ($qty === 0) {
            $qty = 1;
        }
        $decoration = Decorationpacket::find($id);
        if ($decoration->stok < $qty) {
            return back()->with('warning', 'Stok item sudah habis');
        }
        try {
            $decoration->carts()->create([
                'user_id' => auth()->user()->id, //1 diganti dengan Auth::user()->id nanti
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
