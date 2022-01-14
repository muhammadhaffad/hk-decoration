<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function view()
    {
        $galleries = Gallery::paginate(10);
        return view('admin.gallery', [
            'galleries' => $galleries
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_galeri' => 'required',
            'slug_galeri' => 'required',
            'foto' => 'required|array|min:1',
            'foto.*' => 'required|file|image|max:2042',
            'deskripsi' => 'required|array|min:1',
            'deskripsi.*' => 'required',
        ]);
        $gallery = Gallery::create([
            'nama' => $data['nama_galeri'],
            'slug' => $data['slug_galeri']
        ]);
        foreach ($data['foto'] as $index => $foto) {
            $data['foto'][$index] = $foto->store('gallery-images');
            Photo::create([
                'gallery_id' => $gallery->id,
                'foto' => $data['foto'][$index],
                'deskripsi' => $data['deskripsi'][$index]
            ]);
        }
        return back();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric'
        ]);
        $gallery = Gallery::find($request->id);
        $gallery->delete();
        return back();
    }

    public function update_view($slug)
    {
        $gallery = Gallery::where('slug', $slug)->first();
        return view('admin.gallery-update', [
            'gallery' => $gallery
        ]);
    }

    public function store_image($slug, Request $request)
    {
        $request->validate([
            'foto' => 'required|file|image|max:2048',
            'deskripsi' => 'required'
        ]);
        $gallery = Gallery::where('slug', $slug)->first();
        $gallery->photos()->create([
            'foto' => $request->file('foto')->store('gallery-images'),
            'deskripsi' => $request->deskripsi,
        ]);
        return back();
    }

    public function update_image($slug, Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'foto' => 'file|image|max:2048',
            'deskripsi' => 'required'
        ]);
        $gallery = Gallery::where('slug', $slug)->first();
        $photo = $gallery->photos()->find($request->id);
        if ($request->file('foto')) {
            $photo->foto = $request->file('foto')->store('gallery-images');
        }
        $photo->deskripsi = $request->deskripsi;
        $photo->save();
        return back();
    }

    public function delete_image($slug, Request $request)
    {
        $request->validate([
            'foto-id' => 'required|numeric',
        ]);
        $gallery = Gallery::where('slug', $slug)->first();
        $gallery->photos()->find($request->post('foto-id'))->delete();
        return back();
    }
}
