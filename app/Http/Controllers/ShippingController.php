<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function view(Request $request) {
        $shippings = Shipping::all();
        $res = [];
        foreach ($shippings as $shipping) {
            $data = [
                'id' => $shipping->id,
                'kabupaten' => $shipping->regency()->first()->nama,
                'kecamatan' => $shipping->district()->first()->nama,
                'harga' => $shipping->harga
            ];
            array_push($res, $data);
        }
        return json_encode($res);
    }
}
