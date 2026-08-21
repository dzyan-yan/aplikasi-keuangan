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
use App\Http\Controllers\SebrakanController;

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
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->middleware('role:superadmin,admin,bendahara,pengurus')
        ->name('dashboard');

    /*
|--------------------------------------------------------------------------
| ANGGOTA
|--------------------------------------------------------------------------
*/

    // SUPERADMIN & admin
    Route::middleware('role:superadmin,admin')->group(function () {

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
        ])
            ->whereNumber('anggota')
            ->name('anggota.edit');

        Route::match(['PUT', 'PATCH'], '/anggota/{anggota}', [
            AnggotaController::class,
            'update'
        ])
            ->whereNumber('anggota')
            ->name('anggota.update');

        Route::delete('/anggota/{anggota}', [
            AnggotaController::class,
            'destroy'
        ])
            ->whereNumber('anggota')
            ->name('anggota.destroy');
    });


    // SEMUA ROLE
    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        Route::get('/anggota', [
            AnggotaController::class,
            'index'
        ])->name('anggota.index');

        Route::get('/anggota/{anggota}', [
            AnggotaController::class,
            'show'
        ])
            ->whereNumber('anggota')
            ->name('anggota.show');
    });
    /*
|--------------------------------------------------------------------------
| PINJAMAN
|--------------------------------------------------------------------------
|
| Lihat:
| semua role
|
| Kelola:
| superadmin, bendahara
|
*/

    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        // LIST PINJAMAN
        Route::get('/pinjaman', [
            PinjamanController::class,
            'index'
        ])->name('pinjaman.index');

        // DETAIL PINJAMAN
        Route::get('/pinjaman/{pinjaman}', [
            PinjamanController::class,
            'show'
        ])
            ->whereNumber('pinjaman')
            ->name('pinjaman.show');
    });


    Route::middleware('role:superadmin,admin,bendahara')->group(function () {

        // TAMBAH PINJAMAN
        Route::get('/pinjaman/create', [
            PinjamanController::class,
            'create'
        ])->name('pinjaman.create');

        // SIMPAN PINJAMAN
        Route::post('/pinjaman', [
            PinjamanController::class,
            'store'
        ])->name('pinjaman.store');

        // EDIT PINJAMAN
        Route::get('/pinjaman/{pinjaman}/edit', [
            PinjamanController::class,
            'edit'
        ])
            ->whereNumber('pinjaman')
            ->name('pinjaman.edit');

        // UPDATE PINJAMAN
        Route::match(['put', 'patch'], '/pinjaman/{pinjaman}', [
            PinjamanController::class,
            'update'
        ])
            ->whereNumber('pinjaman')
            ->name('pinjaman.update');

        // HAPUS PINJAMAN
        Route::delete('/pinjaman/{pinjaman}', [
            PinjamanController::class,
            'destroy'
        ])
            ->whereNumber('pinjaman')
            ->name('pinjaman.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ANGSURAN
    |--------------------------------------------------------------------------
    |
    | Semua role dapat melihat.
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
| SEBRAKAN
|--------------------------------------------------------------------------
|
| Lihat:
| semua role
|
| Kelola:
| superadmin, admin, bendahara
|
*/

    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        Route::get('/sebrakan', [
            SebrakanController::class,
            'index'
        ])->name('sebrakan.index');

        Route::get('/sebrakan/{sebrakan}', [
            SebrakanController::class,
            'show'
        ])
            ->whereNumber('sebrakan')
            ->name('sebrakan.show');
    });


    Route::middleware('role:superadmin,admin,bendahara')->group(function () {

        // Tambah Sebrakan
        Route::get('/sebrakan/create', [
            SebrakanController::class,
            'create'
        ])->name('sebrakan.create');

        // Simpan Sebrakan
        Route::post('/sebrakan', [
            SebrakanController::class,
            'store'
        ])->name('sebrakan.store');

        // Bayar / lunasi Sebrakan
        Route::post('/sebrakan/{sebrakan}/bayar', [
            SebrakanController::class,
            'bayar'
        ])
            ->whereNumber('sebrakan')
            ->name('sebrakan.bayar');
    });


    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN
    |--------------------------------------------------------------------------
    |
    | Lihat:
    | semua role
    |
    | Input:
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

    Route::middleware('role:superadmin,admin,bendahara')->group(function () {

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
*/

    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        // LIST
        Route::get('/pemasukan', [
            PemasukanController::class,
            'index'
        ])->name('pemasukan.index');
    });


    Route::middleware('role:superadmin,admin,bendahara')->group(function () {

        // CREATE HARUS SEBELUM /{pemasukan}
        Route::get('/pemasukan/create', [
            PemasukanController::class,
            'create'
        ])->name('pemasukan.create');

        // STORE
        Route::post('/pemasukan', [
            PemasukanController::class,
            'store'
        ])->name('pemasukan.store');

        // EDIT
        Route::get('/pemasukan/{pemasukan}/edit', [
            PemasukanController::class,
            'edit'
        ])
            ->whereNumber('pemasukan')
            ->name('pemasukan.edit');

        // UPDATE
        Route::match(['PUT', 'PATCH'], '/pemasukan/{pemasukan}', [
            PemasukanController::class,
            'update'
        ])
            ->whereNumber('pemasukan')
            ->name('pemasukan.update');

        // DELETE
        Route::delete('/pemasukan/{pemasukan}', [
            PemasukanController::class,
            'destroy'
        ])
            ->whereNumber('pemasukan')
            ->name('pemasukan.destroy');
    });


    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        // DETAIL HARUS PALING BAWAH
        Route::get('/pemasukan/{pemasukan}', [
            PemasukanController::class,
            'show'
        ])
            ->whereNumber('pemasukan')
            ->name('pemasukan.show');
    });

    /*
|--------------------------------------------------------------------------
| PENGELUARAN
|--------------------------------------------------------------------------
*/

    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        // LIST
        Route::get('/pengeluaran', [
            PengeluaranController::class,
            'index'
        ])->name('pengeluaran.index');
    });


    Route::middleware('role:superadmin,admin,bendahara')->group(function () {

        // CREATE HARUS SEBELUM /{pengeluaran}
        Route::get('/pengeluaran/create', [
            PengeluaranController::class,
            'create'
        ])->name('pengeluaran.create');

        // STORE
        Route::post('/pengeluaran', [
            PengeluaranController::class,
            'store'
        ])->name('pengeluaran.store');

        // EDIT
        Route::get('/pengeluaran/{pengeluaran}/edit', [
            PengeluaranController::class,
            'edit'
        ])
            ->whereNumber('pengeluaran')
            ->name('pengeluaran.edit');

        // UPDATE
        Route::match(['PUT', 'PATCH'], '/pengeluaran/{pengeluaran}', [
            PengeluaranController::class,
            'update'
        ])
            ->whereNumber('pengeluaran')
            ->name('pengeluaran.update');

        // DELETE
        Route::delete('/pengeluaran/{pengeluaran}', [
            PengeluaranController::class,
            'destroy'
        ])
            ->whereNumber('pengeluaran')
            ->name('pengeluaran.destroy');
    });


    Route::middleware('role:superadmin,admin,bendahara,pengurus')->group(function () {

        // DETAIL HARUS PALING BAWAH
        Route::get('/pengeluaran/{pengeluaran}', [
            PengeluaranController::class,
            'show'
        ])
            ->whereNumber('pengeluaran')
            ->name('pengeluaran.show');
    });




    Route::get('/pemasukan/export', [
        PemasukanController::class,
        'export'
    ])->name('pemasukan.export');

    Route::get('/pengeluaran/export', [
        PengeluaranController::class,
        'export'
    ])->name('pengeluaran.export');

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




/*
|--------------------------------------------------------------------------
| DEBUG SESSION
|--------------------------------------------------------------------------
*/

Route::get('/debug-session', function () {

    return response()->json([
        'session_id'  => session()->getId(),
        'admin_login' => session('admin_login'),
        'admin_id'    => session('admin_id'),
        'admin_nama'  => session('admin_nama'),
        'admin_role'  => session('admin_role'),
        'session_all' => session()->all(),
    ]);
});


Route::get('/test-anggota-create', function () {
    return 'ROUTE ANGGOTA CREATE BERHASIL';
});
