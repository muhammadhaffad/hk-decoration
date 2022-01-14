<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'user');
        return view('admin.customer', [
            'customers' => $customers
        ]);
    }

    public function update(Request $request)
    {
        $customer = User::find($request->customer_id);
        if ($customer == null) {
            return back();
        }
        $data = $request->validateWithBag('update_customer', [
            'customer_id' => 'required|numeric',
            'username' => $customer->username !== $request->username ? 'required|min:4|max:20|unique:users,username' : 'required|min:4|max:20',
            'email' => $customer->email !== $request->email ? 'required|min:4|max:20|unique:users,email' : 'required|min:4|max:20',
            'password' => 'nullable|min:8'
        ]);
        
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
            $customer->password = $data['password'];
        }
        $customer->username = $data['username'];
        $customer->email = $data['email'];
        $customer->save();
        return back();
    }
    public function inactive(Request $request) {
        $request->validate([
            'customer_id' => 'required|numeric'
        ]);
        User::find($request->customer_id)->update(['status' => 'inactive']);
        return back();
    }
    public function active(Request $request) {
        $request->validate([
            'customer_id' => 'required|numeric'
        ]);
        User::find($request->customer_id)->update(['status' => 'active']);
        return back();
    }
}
