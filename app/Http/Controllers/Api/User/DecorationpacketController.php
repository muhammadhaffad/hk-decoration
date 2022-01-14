<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Decorationpacket;
use Illuminate\Http\Request;

class DecorationpacketController extends Controller
{
    public function index(Request $request) {
        $products = new Decorationpacket;
        if (@$request->category) {
            $category = Category::where('nama',$request->category)->first();
            if ($category) {
                $products = $category->decorationpackets();
            } else {
                return response(['message' => 'Kategori tidak ditemukan'], 404);
            }
        }
        if ($products) {
            return ProductResource::collection($products->get());
        }
    }

    public function show($id) {
        $products = Decorationpacket::find($id);
        if ($products) {
            return new ProductResource($products);
        } 
        return response(['message' => 'Item tidak ditemukan'], 404); 
    } 
}
