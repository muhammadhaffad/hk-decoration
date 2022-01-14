<?php

namespace App\Http\Controllers;

use App\Models\Homepage;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function view() {
        return view('home', [
            'homepages' => Homepage::orderBy('id', 'desc')->get(),
        ]);
    }
}
