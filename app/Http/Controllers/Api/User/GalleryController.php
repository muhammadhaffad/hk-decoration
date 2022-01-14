<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Page\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index() {
        return GalleryResource::collection(Gallery::all());
    }

    public function show($slug) {
        $gallery = Gallery::where('slug', $slug)->first();
        return new GalleryResource($gallery);
    }
}
