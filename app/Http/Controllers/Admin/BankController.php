<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function view()
    {
        $banks = new Bank;
        return view('admin.bank', [
            'banks' => $banks
        ]);
    }
    public function update(Request $request)
    {
        $data = $request->validate([
            'bank_id' => 'required|numeric',
            'logo' => 'file|image|max:1024',
            'nama' => 'required',
            'keterangan' => 'required'
        ]);
        $bank = Bank::find($data['bank_id']);
        if ($request->file('logo')) {
            $data['logo'] = $request->file('logo')->store('bank-logos');
            $bank->logo = $data['logo'];
        }
        $bank->nama = $data['nama'];
        $bank->keterangan = $data['keterangan'];
        $bank->save();
        return back();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'logo' => 'required|file|image|max:1024',
            'nama' => 'required',
            'keterangan' => 'required'
        ]);
        $bank = new Bank;
        $data['logo'] = $request->file('logo')->store('bank-logos');
        $bank->logo = $data['logo'];
        $bank->nama = $data['nama'];
        $bank->keterangan = $data['keterangan'];
        $bank->save();
        return back();
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'bank_id' => 'required|numeric',
        ]);
        Bank::find($data['bank_id'])->delete();
        return back();
    }
}
