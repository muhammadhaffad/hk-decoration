<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Regency;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function view() {
        $regencies = Regency::all();
        $districts = District::all();
        $shippings = Shipping::all();
        return view('admin.shipping', [
            'regencies' => $regencies,
            'districts' => $districts,
            'shippings' => $shippings,
        ]);
    }

    public function add_regency(Request $request) {
        $request->validate([
            'kabupaten' => 'required'
        ]);
        Regency::create([
            'nama' => $request->kabupaten
        ]);
        return back();
    }
    
    public function add_district(Request $request) {
        $request->validate([
            'kecamatan' => 'required'
        ]);
        District::create([
            'nama' => $request->kecamatan
        ]);
        return back();
    }

    public function add_shipping(Request $request) {
        $request->validate([
            'kabupaten' => 'required|numeric',
            'kecamatan' => 'required|numeric',
            'harga' => 'required|numeric'
        ]);
        Shipping::create([
            'regency_id' => $request->kabupaten,
            'district_id' => $request->kecamatan,
            'harga' => $request->harga
        ]);
        return back();
    }

    public function update_regency(Request $request) {
        $request->validate([
            'kabupaten_id' => 'required|numeric',
            'kabupaten_nama' => 'required'
        ]);
        $regency = Regency::find($request->kabupaten_id);
        $regency->nama = $request->kabupaten_nama;
        $regency->save();
        return back();
    }
    
    public function update_district(Request $request) {
        $request->validate([
            'kecamatan_id' => 'required|numeric',
            'kecamatan_nama' => 'required'
        ]);
        $district = District::find($request->kecamatan_id);
        $district->nama = $request->kecamatan_nama;
        $district->save();
        return back();
    }

    public function update_shipping(Request $request) {
        $request->validate([
            'id_ongkir' => 'required|numeric',
            'kabupaten' => 'required|numeric',
            'kecamatan' => 'required|numeric',
            'harga' => 'required|numeric'
        ]);
        $shipping = Shipping::find($request->id_ongkir);
        $shipping->regency_id = $request->kabupaten;
        $shipping->district_id = $request->kecamatan;
        $shipping->harga = $request->harga;
        $shipping->save();
        return back();
    }

    public function delete_regency(Request $request) {
        $request->validate([
            'id' => 'required|numeric'
        ]);
        Regency::find($request->id)->shipping()->delete();
        Regency::find($request->id)->delete();
        return back();
    }
    
    public function delete_district(Request $request) {
        $request->validate([
            'id' => 'required|numeric'
        ]);
        District::find($request->id)->shipping()->delete();
        District::find($request->id)->delete();
        return back();
    }

    public function delete_shipping(Request $request) {
        $request->validate([
            'id' => 'required|numeric'
        ]);
        Shipping::find($request->id)->delete();
        return back();
    }
}
