<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Decorationpacket;
use Illuminate\Http\Request;

class DecorationPacketController extends Controller
{
    public function view(Request $request)
    {
        $decorpackets = new Decorationpacket;
        return view('admin.decoration-packet', [
            'decorationpackets' => $decorpackets,
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'gambar' => 'file|image|max:1024',
            'nama' => 'required',
            'stok' => 'required|min:1|max:999',
            'kategori' => 'required|numeric',
            'harga' => 'required|numeric',
            'keterangan' => 'required'
        ]);
        $decorpacket = Decorationpacket::find($data['id']);
        if ($request->file('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('decoration-images');
            $decorpacket->gambar = $data['gambar'];
        }
        $decorpacket->nama = $data['nama'];
        $decorpacket->stok = $data['stok'];
        $decorpacket->category_id = $data['kategori'];
        $decorpacket->harga = $data['harga'];
        $decorpacket->keterangan = $data['keterangan'];
        $decorpacket->save();
        return back();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'gambar' => 'required|file|image|max:1024',
            'nama' => 'required',
            'stok' => 'required|min:1|max:999',
            'kategori' => 'required|numeric',
            'harga' => 'required|numeric',
            'keterangan' => 'required'
        ]);
        $decorpacket = new Decorationpacket;
        $data['gambar'] = $request->file('gambar')->store('decoration-images');
        $decorpacket->gambar = $data['gambar'];
        $decorpacket->nama = $data['nama'];
        $decorpacket->stok = $data['stok'];
        $decorpacket->category_id = $data['kategori'];
        $decorpacket->harga = $data['harga'];
        $decorpacket->keterangan = $data['keterangan'];
        $decorpacket->save();
        return back();
    }

    public function destroy(Request $request) {
        Decorationpacket::find($request->id)->delete();
        return back();
    }

    public function detailDecor(Request $request)
    {
        $decorpacket = Decorationpacket::find($request->id);
        return response()->json($decorpacket);
    }
}
