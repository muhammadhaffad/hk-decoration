<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Decorationitem;
use Illuminate\Http\Request;

class DecorationItemController extends Controller
{
    public function view()
    {
        $decoritems = new Decorationitem;
        return view('admin.decoration-item', [
            'decorationitems' => $decoritems,
            'categories' => Category::all(),
        ]);
    }
    
    public function detailDecor(Request $request)
    {
        $decoritem = Decorationitem::find($request->id);
        return response()->json($decoritem);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'gambar' => 'file|image|max:1024',
            'nama' => 'required',
            'stok' => 'required|min:1|max:999',
            'harga' => 'required|numeric',
            'keterangan' => 'required'
        ]);
        $decorpacket = Decorationitem::find($data['id']);
        if ($request->file('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('decoration-images');
            $decorpacket->gambar = $data['gambar'];
        }
        $decorpacket->nama = $data['nama'];
        $decorpacket->stok = $data['stok'];
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
            'harga' => 'required|numeric',
            'keterangan' => 'required'
        ]);
        $decorpacket = new Decorationitem;
        $data['gambar'] = $request->file('gambar')->store('decoration-images');
        $decorpacket->gambar = $data['gambar'];
        $decorpacket->nama = $data['nama'];
        $decorpacket->stok = $data['stok'];
        $decorpacket->harga = $data['harga'];
        $decorpacket->keterangan = $data['keterangan'];
        $decorpacket->save();
        return back();
    }

    public function destroy(Request $request) {
        Decorationitem::find($request->id)->delete();
        return back();
    }
}
