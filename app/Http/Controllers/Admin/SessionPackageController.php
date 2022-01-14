<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Sessionpackage;
use Illuminate\Http\Request;

class SessionPackageController extends Controller
{
    public function view()
    {
        $sessionpackages = new Sessionpackage;
        return view('admin.session-package', [
            'sessionpackages' => $sessionpackages,
            'categories' => Category::all(),
        ]);
    }
    public function detailSession(Request $request)
    {
        $sesspackage = Sessionpackage::find($request->id);
        return response()->json($sesspackage);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'gambar' => 'file|image|max:1024',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'keterangan' => 'required'
        ]);
        $decorpacket = Sessionpackage::find($data['id']);
        if ($request->file('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('decoration-images');
            $decorpacket->gambar = $data['gambar'];
        }
        $decorpacket->nama = $data['nama'];
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
            'harga' => 'required|numeric',
            'keterangan' => 'required'
        ]);
        $decorpacket = new Sessionpackage;
        $data['gambar'] = $request->file('gambar')->store('decoration-images');
        $decorpacket->gambar = $data['gambar'];
        $decorpacket->nama = $data['nama'];
        $decorpacket->harga = $data['harga'];
        $decorpacket->keterangan = $data['keterangan'];
        $decorpacket->save();
        return back();
    }

    public function destroy(Request $request) {
        Sessionpackage::find($request->id)->delete();
        return back();
    }
}
