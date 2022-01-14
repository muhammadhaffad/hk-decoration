<?php

namespace App\Http\Controllers;

use App\Models\Sessionpackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParternController extends Controller
{
    public function view(Request $request) {
        $sesspackages = Sessionpackage::orderBy('id', 'desc');
        return view('partern', [
            'sesspackages' => $sesspackages
        ]);
    }

    public function show($id)
    {
        $sessionpackage = Sessionpackage::find($id);
        return view('partern-view', [
            'sessionpackage' => $sessionpackage
        ]);
    }

    public function addToCart(Request $request, $id) {
        $sesspackage = Sessionpackage::find($id);
        try {
            $sesspackage->carts()->create([
                'user_id' => Auth::user()->id, //1 diganti dengan Auth::user()->id nanti
                'kuantitas' => 1,
            ]);
            return back()->with('success', 'Item berhasil ditambahkan ke keranjang');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return back()->with('warning', 'Item sudah masuk di keranjang');
            }
        }
    }

    public function addReview(Request $request, $id) {
        $d = Sessionpackage::find($id);
        $data = $request->validate([
            'judul' => 'required|min:3|max:100',
            'rating' => 'required|min:0|max:5|numeric',
            'gambar' => 'nullable|file|image|max:1024',
            'isi' => 'required|min:3|max:1500'
        ]);
        $data['user_id'] = auth()->user()->id;
        $d->testimonials()->create($data);
        return back();
    }
}
