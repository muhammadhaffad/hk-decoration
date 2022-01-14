<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'role' => 'superadmin'])) {
            $request->session()->regenerate();

            return redirect()->intended('/admin/dashboard');
        }

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'role' => 'admin'])) {
            $request->session()->regenerate();

            return redirect()->intended('/admin/dashboard');
        }
        return back()->with('error', 'Username atau password salah!');
    }

    public function addAdmin(Request $request)
    {
        $data = $request->validateWithBag('add_admin',[
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'admin';
        User::create($data);
        return back();
    }
    public function view()
    {
        $admins = User::where('role', 'admin');
        return view('admin.employee', [
            'admins' => $admins
        ]);
    }
    public function update(Request $request)
    {
        $data = $request->validateWithBag('update_admin', [
            'admin_id' => 'required|numeric',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8'
        ]);
        $admin = User::find($data['admin_id']);
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
            $admin->password = $data['password'];
        }
        $admin->username = $data['username'];
        $admin->email = $data['email'];
        $admin->save();
        return back();
    }
    public function destroy(Request $request) {
        $request->validate([
            'admin_id' => 'required|numeric'
        ]);
        User::find($request->admin_id)->delete();
        return back();
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
