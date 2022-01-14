<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Decorationitem;
use Illuminate\Http\Request;

class DecorationitemController extends Controller
{
    public function index() {
        $products = new Decorationitem;
        if ($products) {
            return ProductResource::collection($products->get());
        }
        return response(['message' => 'data kosong'], 200);
    }

    public function show($id) {
        $products = Decorationitem::find($id);
        if ($products) {
            return new ProductResource($products);
        } 
        return response(['message' => 'Item tidak ditemukan'], 404); 
    } 
}
