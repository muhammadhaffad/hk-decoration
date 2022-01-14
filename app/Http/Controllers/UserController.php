<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'role' => 'user', 'status' => 'active' ])) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }
        return back()->with('error', 'Username atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(Request $request)
    {
        $data = $request->validate(
            [
                'nama' => 'required',
                'tglLahir' => 'required|date',
                'nomorTlp' => 'required',
                'alamat' => 'required',
                'email' => 'required|email',
                'username' => 'required',
                'password' => 'required',
                'fotoKtp' => 'image|file|max:1024',
                'fotoProfil' => 'image|file|max:1024',
            ]
        );
        if ($request->file('fotoKtp') != null && $request->file('fotoProfil')) {
            $data['fotoKtp'] = $request->file('fotoKtp')->store('ktp-images');
            $data['fotoProfil'] = $request->file('fotoProfil')->store('profile-images');
        }
        $data['password'] = Hash::make($data['password']);
        $user = new User;
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->role = 'user';
        $user->save();
        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->nama = $data['nama'];
        $customer->tanggalLahir = $data['tglLahir'];
        $customer->nomorTelepon = $data['nomorTlp'];
        $customer->alamat = $data['alamat'];
        $customer->fotoKtp = $data['fotoKtp'];
        $customer->fotoProfil = $data['fotoProfil'];
        $customer->save();
        return back()->with('success', 'Akun berhasil dibuat, silahkan login!');
    }

    public function profile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return view('profile', [
            'user' => $user
        ]);
    }

    public function editprofile(Request $request)
    {
        $data = $request->validate(
            [
                'nama' => 'required',
                'tanggalLahir' => 'required|date',
                'nomorTelepon' => 'required',
                'alamat' => 'required',
                'email' => 'required|email',
                'fotoKtp' => 'image|file|max:1024',
                'fotoProfil' => 'image|file|max:1024',
            ]
        );
        if ($request->file('fotoKtp')) 
            $data['fotoKtp'] = $request->file('fotoKtp')->store('ktp-images');
        if ($request->file('fotoProfil'))
            $data['fotoProfil'] = $request->file('fotoProfil')->store('profile-images');
        $user = User::find(Auth::user()->id);
        $user->email = $data['email'];
        $user->save();
        $customer = $user->customer()->first();
        $customer->nama = $data['nama'];
        $customer->tanggalLahir = $data['tanggalLahir'];
        $customer->nomorTelepon = $data['nomorTelepon'];
        $customer->alamat = $data['alamat'];
        if ($request->file('fotoKtp')) 
            $customer->fotoKtp = $data['fotoKtp'];
        if ($request->file('fotoProfil'))
            $customer->fotoProfil = $data['fotoProfil'];
        $customer->save();
        return back();
    }
}
