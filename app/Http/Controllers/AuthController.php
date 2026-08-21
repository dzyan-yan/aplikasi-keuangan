<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        // Regenerasi session setelah login
        $request->session()->regenerate();

        $request->session()->put([
            'admin_login' => true,
            'admin_id'    => $admin->id_admin,
            'admin_nama'  => $admin->nama,
            'admin_role'  => $admin->role,
        ]);

        return redirect()->route('dashboard');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()
            ->route('login')
            ->with('success', 'Berhasil logout.');
    }
}
