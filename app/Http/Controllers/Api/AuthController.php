<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$token = auth()->guard('api')->attempt($request->only('username', 'password'))) {
            return response(null, 401);
        }

        return response()->json(compact('token'));
    }

    public function logout() {
        auth()->guard('api')->logout();
        return response([
            'message' => 'logout successfully'
        ], 200);
    }

    public function register(Request $request) {
        $data = $request->validate(
            [
                'nama' => 'required',
                'tglLahir' => 'required|date',
                'nomorTlp' => 'required',
                'alamat' => 'required',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|unique:users,username',
                'password' => 'required',
                'fotoKtp' => 'required|image|file|max:1024',
                'fotoProfil' => 'required|image|file|max:1024',
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
        return response([
            'message' => 'register successfully'
        ], 200);
    }
}
