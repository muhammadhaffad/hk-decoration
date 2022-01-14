<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function view()
    {
        $galleries = Gallery::orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('gallery', [
            'galleries' => $galleries
        ]);
    }

    public function gallery(Request $request) 
    {
        $gallery = Gallery::where('slug', $request->slug)->first();
        return view('gallery-view', [
            'gallery' => $gallery
        ]);
    }
}
