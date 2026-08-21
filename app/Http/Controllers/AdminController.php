<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Daftar admin
     */
    public function index()
    {
        $admins = Admin::orderBy('nama')->get();

        return view('admin.index', compact('admins'));
    }


    /**
     * Form tambah admin
     */
    public function create()
    {
        $roles = [
            'admin',
            'bendahara',
            'pengurus',
            'superadmin',
        ];

        return view('admin.create', compact('roles'));
    }


    /**
     * Simpan admin baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'username' => [
                'required',
                'string',
                'max:50',
                'unique:admins,username',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'bendahara',
                    'pengurus',
                    'superadmin',
                ]),
            ],
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);


        Admin::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);


        return redirect()
            ->route('admin.index')
            ->with(
                'success',
                'User berhasil dibuat.'
            );
    }


    /**
     * Form edit admin
     */
    public function edit(Admin $admin)
    {
        $roles = [
            'admin',
            'bendahara',
            'pengurus',
            'superadmin',
        ];

        return view(
            'admin.edit',
            compact(
                'admin',
                'roles'
            )
        );
    }


    /**
     * Update admin
     */
    public function update(
        Request $request,
        Admin $admin
    ) {

        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('admins', 'username')
                    ->ignore($admin->id_admin, 'id_admin'),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'bendahara',
                    'pengurus',
                    'superadmin',
                ]),
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);


        $admin->nama = $request->nama;

        $admin->username = $request->username;

        $admin->role = $request->role;


        /*
        |--------------------------------------------------------------------------
        | Password hanya diubah jika diisi
        |--------------------------------------------------------------------------
        */

        if ($request->filled('password')) {

            $admin->password =
                Hash::make(
                    $request->password
                );
        }


        $admin->save();


        return redirect()
            ->route('admin.index')
            ->with(
                'success',
                'Data user berhasil diperbarui.'
            );
    }


    /**
     * Hapus admin
     */
    public function destroy(Admin $admin)
    {
        /*
        |--------------------------------------------------------------------------
        | Jangan izinkan menghapus diri sendiri
        |--------------------------------------------------------------------------
        */

        if (
            session('admin_id')
            == $admin->id_admin
        ) {

            return back()->with(
                'error',
                'Anda tidak dapat menghapus akun yang sedang digunakan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Jangan hapus superadmin terakhir
        |--------------------------------------------------------------------------
        */

        if (
            $admin->role === 'superadmin'
            &&
            Admin::where(
                'role',
                'superadmin'
            )->count() <= 1
        ) {

            return back()->with(
                'error',
                'Superadmin terakhir tidak boleh dihapus.'
            );
        }


        $admin->delete();


        return redirect()
            ->route('admin.index')
            ->with(
                'success',
                'User berhasil dihapus.'
            );
    }
}
