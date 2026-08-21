<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Models\Angsuran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PinjamanController extends Controller
{
    public function index()
    {
        $pinjamans = Pinjaman::with('anggota')
            ->latest('id_pinjaman')
            ->get();

        return view('pinjaman.index', compact('pinjamans'));
    }

    public function create()
    {
        $anggotas = Anggota::where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        return view('pinjaman.create', compact('anggotas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_anggota' => [
                'required',
                'exists:anggotas,id_anggota'
            ],

            'tanggal_pinjaman' => [
                'required',
                'date'
            ],

            'jumlah_pinjaman' => [
                'required',
                'numeric',
                'min:1'
            ],

            'bunga_persen' => [
                'required',
                'numeric',
                'min:0'
            ],

            'tenor' => [
                'required',
                'integer',
                'min:1'
            ],

            'periode_hari' => [
                'required',
                'integer',
                'min:1'
            ],
        ]);

        DB::transaction(function () use ($validated) {

            $jumlahPinjaman = (float) $validated['jumlah_pinjaman'];

            $bungaPersen = (float) $validated['bunga_persen'];

            $tenor = (int) $validated['tenor'];

            $periodeHari = (int) $validated['periode_hari'];


            // Hitung bunga flat

            $jumlahBunga =
                $jumlahPinjaman * ($bungaPersen / 100);


            // Total pinjaman

            $totalPinjaman =
                $jumlahPinjaman + $jumlahBunga;


            // Angsuran per periode

            $jumlahAngsuran =
                round($totalPinjaman / $tenor, 2);


            // Nomor pinjaman

            $noPinjaman = 'PJ-' . date('YmdHis');


            // Simpan pinjaman

            $pinjaman = Pinjaman::create([

                'no_pinjaman' => $noPinjaman,

                'id_anggota' => $validated['id_anggota'],

                'tanggal_pinjaman' =>
                $validated['tanggal_pinjaman'],

                'jumlah_pinjaman' =>
                $jumlahPinjaman,

                'bunga_persen' =>
                $bungaPersen,

                'jumlah_bunga' =>
                $jumlahBunga,

                'total_pinjaman' =>
                $totalPinjaman,

                'tenor' =>
                $tenor,

                'periode_hari' =>
                $periodeHari,

                'jumlah_angsuran' =>
                $jumlahAngsuran,

                'status' =>
                'aktif',

            ]);


            // Generate jadwal angsuran

            for ($i = 1; $i <= $tenor; $i++) {

                $jatuhTempo = \Carbon\Carbon::parse(
                    $validated['tanggal_pinjaman']
                )->addDays(
                    $periodeHari * $i
                );


                Angsuran::create([

                    'id_pinjaman' =>
                    $pinjaman->id_pinjaman,

                    'angsuran_ke' =>
                    $i,

                    'jatuh_tempo' =>
                    $jatuhTempo,

                    'jumlah_angsuran' =>
                    $jumlahAngsuran,

                    'jumlah_dibayar' =>
                    0,

                    'denda' =>
                    0,

                    'status' =>
                    'belum_bayar',

                ]);
            }
        });


        return redirect()
            ->route('pinjaman.index')
            ->with(
                'success',
                'Pinjaman berhasil dibuat dan jadwal angsuran telah dibuat.'
            );
    }


    public function show(Pinjaman $pinjaman)
    {
        $pinjaman->load([
            'anggota',
            'angsuran' => function ($query) {
                $query->orderBy('angsuran_ke');
            }
        ]);

        return view('pinjaman.show', compact('pinjaman'));
    }

    public function edit(Pinjaman $pinjaman)
    {
        $pinjaman->load('anggota');

        // Pinjaman yang sudah memiliki pembayaran
        // tidak boleh diedit.
        $sudahBayar = $pinjaman->angsuran()
            ->where('jumlah_dibayar', '>', 0)
            ->exists();

        if ($sudahBayar) {
            return redirect()
                ->route('pinjaman.show', $pinjaman)
                ->with(
                    'error',
                    'Pinjaman tidak dapat diedit karena sudah memiliki pembayaran.'
                );
        }

        $anggotas = Anggota::where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        return view(
            'pinjaman.edit',
            compact('pinjaman', 'anggotas')
        );
    }


    public function update(Request $request, Pinjaman $pinjaman)
    {
        // Jangan izinkan edit jika sudah ada pembayaran
        $sudahBayar = $pinjaman->angsuran()
            ->where('jumlah_dibayar', '>', 0)
            ->exists();

        if ($sudahBayar) {
            return redirect()
                ->route('pinjaman.show', $pinjaman)
                ->with(
                    'error',
                    'Pinjaman tidak dapat diedit karena sudah memiliki pembayaran.'
                );
        }

        $validated = $request->validate([
            'id_anggota' => [
                'required',
                'exists:anggotas,id_anggota'
            ],

            'tanggal_pinjaman' => [
                'required',
                'date'
            ],

            'jumlah_pinjaman' => [
                'required',
                'numeric',
                'min:1'
            ],

            'bunga_persen' => [
                'required',
                'numeric',
                'min:0'
            ],

            'tenor' => [
                'required',
                'integer',
                'min:1'
            ],

            'periode_hari' => [
                'required',
                'integer',
                'min:1'
            ],
        ]);

        DB::transaction(function () use ($validated, $pinjaman) {

            $jumlahPinjaman = (float) $validated['jumlah_pinjaman'];

            $bungaPersen = (float) $validated['bunga_persen'];

            $tenor = (int) $validated['tenor'];

            $periodeHari = (int) $validated['periode_hari'];

            // Hitung bunga
            $jumlahBunga =
                $jumlahPinjaman * ($bungaPersen / 100);

            // Total pinjaman
            $totalPinjaman =
                $jumlahPinjaman + $jumlahBunga;

            // Angsuran per periode
            $jumlahAngsuran =
                round($totalPinjaman / $tenor, 2);

            // Update pinjaman
            $pinjaman->update([

                'id_anggota' =>
                $validated['id_anggota'],

                'tanggal_pinjaman' =>
                $validated['tanggal_pinjaman'],

                'jumlah_pinjaman' =>
                $jumlahPinjaman,

                'bunga_persen' =>
                $bungaPersen,

                'jumlah_bunga' =>
                $jumlahBunga,

                'total_pinjaman' =>
                $totalPinjaman,

                'tenor' =>
                $tenor,

                'periode_hari' =>
                $periodeHari,

                'jumlah_angsuran' =>
                $jumlahAngsuran,
            ]);

            /*
        |--------------------------------------------------------------------------
        | Hapus jadwal angsuran lama
        |--------------------------------------------------------------------------
        |
        | Aman dilakukan karena sebelumnya sudah dipastikan
        | belum ada pembayaran.
        |
        */

            $pinjaman->angsuran()->delete();

            /*
        |--------------------------------------------------------------------------
        | Generate ulang jadwal angsuran
        |--------------------------------------------------------------------------
        */

            for ($i = 1; $i <= $tenor; $i++) {

                $jatuhTempo = \Carbon\Carbon::parse(
                    $validated['tanggal_pinjaman']
                )->addDays(
                    $periodeHari * $i
                );

                Angsuran::create([

                    'id_pinjaman' =>
                    $pinjaman->id_pinjaman,

                    'angsuran_ke' =>
                    $i,

                    'jatuh_tempo' =>
                    $jatuhTempo,

                    'jumlah_angsuran' =>
                    $jumlahAngsuran,

                    'jumlah_dibayar' =>
                    0,

                    'denda' =>
                    0,

                    'status' =>
                    'belum_bayar',
                ]);
            }
        });

        return redirect()
            ->route('pinjaman.show', $pinjaman)
            ->with(
                'success',
                'Pinjaman dan jadwal angsuran berhasil diperbarui.'
            );
    }
}
