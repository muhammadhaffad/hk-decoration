<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homepage;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function view() {
        return view('admin.home-page', [
            'foto' => Homepage::where('type', 'foto')->get(),
            'video' => Homepage::where('type', '!=','foto')->get()
        ]);
    }
    public function store(Request $request) {
        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'video' => 'required_without_all:foto,link|file|mimes:mp4,mov,ogg',
            'foto' => 'required_without_all:video,link|file|image',
            'link' => 'required_without_all:video,foto',
            'type' => 'required|in:video,foto,link'
        ]);
        if ($request->file('foto')) {
            $data['media'] = $request->file('foto')->store('home-images');
        }
        if ($request->file('video')) {
            $data['media'] = $request->file('video')->store('home-videos');
        }
        if ($request->link) {
            $data['media'] = $request->link;
        }
        Homepage::create([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'media' => $data['media'],
            'type' => $data['type']
        ]);
        return back();
    }
    public function update(Request $request) {
        $request->validate([
            'id' => 'required|numeric',
            'judul' => 'required',
            'deskripsi' => 'required',
            'video' => 'nullable|file|mimes:mp4,mov,ogg',
            'foto' => 'nullable|file|image',
            'link' => 'nullable',
            'type' => 'nullable|in:video,foto,link'
        ]);
        $homepage = Homepage::find($request->id);
        if ($request->file('foto')) {
            $homepage->media = $request->file('foto')->store('home-images');
            $homepage->type = $request->type;
        }
        if ($request->file('video')) {
            $homepage->media = $request->file('video')->store('home-videos');
            $homepage->type = $request->type;
        }
        if ($request->link) {
            $homepage->media = $request->link;
            $homepage->type = $request->type;
        }
        $homepage->judul = $request->judul;
        $homepage->deskripsi = $request->deskripsi;
        $homepage->save();
        return back();
    }

    public function destroy(Request $request) {
        $request->validate([
            'id' => 'required|numeric'
        ]);
        $homepage = Homepage::find($request->id);
        $homepage->delete();
        return back();
    }
}
