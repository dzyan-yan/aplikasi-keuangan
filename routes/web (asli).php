<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', [
    AuthController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
])->name('login.process');

Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');


/*
|--------------------------------------------------------------------------
| AREA LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('admin.auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ROOT
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    |
    | Semua role dapat melihat dashboard.
    |
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])
        ->middleware('role:superadmin,admin,bendahara,pengurus')
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ANGGOTA
    |--------------------------------------------------------------------------
    |
    | LIHAT:
    | superadmin, admin, bendahara, pengurus
    |
    | KELOLA:
    | superadmin, admin, bendahara
    |
    */

    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        Route::get('/anggota', [
            AnggotaController::class,
            'index'
        ])->name('anggota.index');

        Route::get('/anggota/{anggota}', [
            AnggotaController::class,
            'show'
        ])->name('anggota.show');
    });


    Route::middleware('role:superadmin,admin,bendahara')->group(function () {

        Route::get('/anggota/create', [
            AnggotaController::class,
            'create'
        ])->name('anggota.create');

        Route::post('/anggota', [
            AnggotaController::class,
            'store'
        ])->name('anggota.store');

        Route::get('/anggota/{anggota}/edit', [
            AnggotaController::class,
            'edit'
        ])->name('anggota.edit');

        Route::match(['put', 'patch'], '/anggota/{anggota}', [
            AnggotaController::class,
            'update'
        ])->name('anggota.update');

        Route::delete('/anggota/{anggota}', [
            AnggotaController::class,
            'destroy'
        ])->name('anggota.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | PINJAMAN
    |--------------------------------------------------------------------------
    |
    | LIHAT:
    | superadmin, admin, bendahara, pengurus
    |
    | KELOLA:
    | superadmin, bendahara
    |
    */

    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        Route::get('/pinjaman', [
            PinjamanController::class,
            'index'
        ])->name('pinjaman.index');

        Route::get('/pinjaman/{pinjaman}', [
            PinjamanController::class,
            'show'
        ])->name('pinjaman.show');
    });


    Route::middleware('role:superadmin,bendahara')->group(function () {

        Route::get('/pinjaman/create', [
            PinjamanController::class,
            'create'
        ])->name('pinjaman.create');

        Route::post('/pinjaman', [
            PinjamanController::class,
            'store'
        ])->name('pinjaman.store');

        Route::get('/pinjaman/{pinjaman}/edit', [
            PinjamanController::class,
            'edit'
        ])->name('pinjaman.edit');

        Route::match(['put', 'patch'], '/pinjaman/{pinjaman}', [
            PinjamanController::class,
            'update'
        ])->name('pinjaman.update');

        Route::delete('/pinjaman/{pinjaman}', [
            PinjamanController::class,
            'destroy'
        ])->name('pinjaman.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | ANGSURAN
    |--------------------------------------------------------------------------
    |
    | Angsuran dihasilkan dari PINJAMAN.
    |
    | LIHAT:
    | semua role
    |
    */

    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        Route::get('/angsuran', [
            AngsuranController::class,
            'index'
        ])->name('angsuran.index');

        Route::get('/angsuran/anggota/{anggota}', [
            AngsuranController::class,
            'anggota'
        ])->name('angsuran.anggota');
    });


    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN ANGSURAN
    |--------------------------------------------------------------------------
    |
    | LIHAT:
    | semua role
    |
    | INPUT PEMBAYARAN:
    | superadmin, bendahara
    |
    */

    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        Route::get('/pembayaran/{pembayaran}', [
            PembayaranController::class,
            'show'
        ])->name('pembayaran.show');

        Route::get('/pembayaran/{pembayaran}/kuitansi', [
            PembayaranController::class,
            'kuitansi'
        ])->name('pembayaran.kuitansi');
    });


    Route::middleware('role:superadmin,bendahara')->group(function () {

        Route::get('/angsuran/{angsuran}/bayar', [
            PembayaranController::class,
            'create'
        ])->name('angsuran.bayar');

        Route::post('/angsuran/{angsuran}/bayar', [
            PembayaranController::class,
            'store'
        ])->name('angsuran.bayar.store');
    });


    /*
    |--------------------------------------------------------------------------
    | PEMASUKAN
    |--------------------------------------------------------------------------
    |
    | LIHAT:
    | semua role
    |
    | KELOLA:
    | superadmin, bendahara
    |
    */

    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        Route::get('/pemasukan', [
            PemasukanController::class,
            'index'
        ])->name('pemasukan.index');

        Route::get('/pemasukan/{pemasukan}', [
            PemasukanController::class,
            'show'
        ])->name('pemasukan.show');
    });


    Route::middleware('role:superadmin,bendahara')->group(function () {

        Route::get('/pemasukan/create', [
            PemasukanController::class,
            'create'
        ])->name('pemasukan.create');

        Route::post('/pemasukan', [
            PemasukanController::class,
            'store'
        ])->name('pemasukan.store');

        Route::get('/pemasukan/{pemasukan}/edit', [
            PemasukanController::class,
            'edit'
        ])->name('pemasukan.edit');

        Route::match(['put', 'patch'], '/pemasukan/{pemasukan}', [
            PemasukanController::class,
            'update'
        ])->name('pemasukan.update');

        Route::delete('/pemasukan/{pemasukan}', [
            PemasukanController::class,
            'destroy'
        ])->name('pemasukan.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | PENGELUARAN
    |--------------------------------------------------------------------------
    |
    | LIHAT:
    | semua role
    |
    | KELOLA:
    | superadmin, bendahara
    |
    */

    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        Route::get('/pengeluaran', [
            PengeluaranController::class,
            'index'
        ])->name('pengeluaran.index');

        Route::get('/pengeluaran/{pengeluaran}', [
            PengeluaranController::class,
            'show'
        ])->name('pengeluaran.show');
    });


    Route::middleware('role:superadmin,bendahara')->group(function () {

        Route::get('/pengeluaran/create', [
            PengeluaranController::class,
            'create'
        ])->name('pengeluaran.create');

        Route::post('/pengeluaran', [
            PengeluaranController::class,
            'store'
        ])->name('pengeluaran.store');

        Route::get('/pengeluaran/{pengeluaran}/edit', [
            PengeluaranController::class,
            'edit'
        ])->name('pengeluaran.edit');

        Route::match(['put', 'patch'], '/pengeluaran/{pengeluaran}', [
            PengeluaranController::class,
            'update'
        ])->name('pengeluaran.update');

        Route::delete('/pengeluaran/{pengeluaran}', [
            PengeluaranController::class,
            'destroy'
        ])->name('pengeluaran.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | MANAJEMEN USER
    |--------------------------------------------------------------------------
    |
    | HANYA SUPERADMIN
    |
    */

    Route::middleware('role:superadmin')->group(function () {

        Route::resource('admin', AdminController::class)
            ->except(['show']);
    });
});
