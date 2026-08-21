<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pemasukan;


class PembayaranController extends Controller
{
    /**
     * Form pembayaran angsuran
     */
    public function create(Angsuran $angsuran)
    {
        $angsuran->load([
            'pinjaman.anggota'
        ]);

        $sisa = max(
            0,
            $angsuran->jumlah_angsuran
                - $angsuran->jumlah_dibayar
        );

        return view(
            'pembayaran.create',
            compact(
                'angsuran',
                'sisa'
            )
        );
    }

    public function store(Request $request, Angsuran $angsuran)
    {
        $request->validate([

            'tanggal_bayar' => [
                'required',
                'date',
            ],

            'jumlah_bayar' => [
                'required',
                'numeric',
                'min:1',
            ],

            'denda' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        /*
    |--------------------------------------------------------------------------
    | Load relasi
    |--------------------------------------------------------------------------
    */

        $angsuran->load([
            'pinjaman.anggota'
        ]);


        /*
    |--------------------------------------------------------------------------
    | Pastikan admin login
    |--------------------------------------------------------------------------
    */

        $adminId = session('admin_id');

        if (!$adminId) {

            return redirect()
                ->route('login')
                ->with('error', 'Sesi admin sudah berakhir. Silakan login kembali.');
        }


        /*
    |--------------------------------------------------------------------------
    | Hitung tagihan
    |--------------------------------------------------------------------------
    */

        $totalTagihan =
            (float) $angsuran->jumlah_angsuran
            + (float) $angsuran->denda;


        $totalDibayar =
            (float) $angsuran->jumlah_dibayar;


        $sisaAngsuran = max(
            0,
            $totalTagihan - $totalDibayar
        );


        /*
    |--------------------------------------------------------------------------
    | Jumlah pembayaran
    |--------------------------------------------------------------------------
    */

        $jumlahBayar =
            (float) $request->jumlah_bayar;


        /*
    |--------------------------------------------------------------------------
    | Validasi pembayaran
    |--------------------------------------------------------------------------
    */

        if ($jumlahBayar > $sisaAngsuran) {

            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_bayar' =>
                    'Jumlah pembayaran melebihi sisa tagihan. Sisa tagihan: Rp '
                        . number_format(
                            $sisaAngsuran,
                            0,
                            ',',
                            '.'
                        )
                ]);
        }


        /*
    |--------------------------------------------------------------------------
    | Simpan pembayaran + pemasukan dalam satu transaksi
    |--------------------------------------------------------------------------
    */

        DB::transaction(function () use (
            $request,
            $angsuran,
            $jumlahBayar,
            $adminId,
            $totalTagihan,
            $totalDibayar
        ) {


            /*
        |--------------------------------------------------------------------------
        | 1. Simpan pembayaran
        |--------------------------------------------------------------------------
        */

            $pembayaran = Pembayaran::create([

                'id_angsuran' =>
                $angsuran->id_angsuran,

                'tanggal_bayar' =>
                $request->tanggal_bayar,

                'jumlah_bayar' =>
                $jumlahBayar,

                'denda' =>
                $request->denda ?? 0,

                'keterangan' =>
                $request->keterangan,

                'id_admin' =>
                $adminId,

            ]);


            /*
        |--------------------------------------------------------------------------
        | 2. Update jumlah dibayar
        |--------------------------------------------------------------------------
        */

            $totalDibayarBaru =
                $totalDibayar + $jumlahBayar;


            /*
        |--------------------------------------------------------------------------
        | 3. Tentukan status
        |--------------------------------------------------------------------------
        */

            if ($totalDibayarBaru >= $totalTagihan) {

                $status = 'lunas';

                $tanggalLunas =
                    $request->tanggal_bayar;
            } else {

                $status = 'sebagian';

                $tanggalLunas = null;
            }


            /*
        |--------------------------------------------------------------------------
        | 4. Update angsuran
        |--------------------------------------------------------------------------
        */

            $angsuran->update([

                'jumlah_dibayar' =>
                $totalDibayarBaru,

                'status' =>
                $status,

                'tanggal_lunas' =>
                $tanggalLunas,

            ]);


            /*
        |--------------------------------------------------------------------------
        | 5. Buat pemasukan otomatis
        |--------------------------------------------------------------------------
        */

            Pemasukan::create([

                'tanggal' =>
                $request->tanggal_bayar,

                'kategori' =>
                'Angsuran',

                'sumber' =>
                $angsuran->pinjaman->anggota->nama,

                'keterangan' =>
                'Pembayaran angsuran ke-'
                    . $angsuran->angsuran_ke
                    . ' - Pinjaman '
                    . $angsuran->pinjaman->no_pinjaman,

                'jumlah' =>
                $jumlahBayar,

                /*
            |--------------------------------------------------------------------------
            | Hubungkan dengan pembayaran
            |--------------------------------------------------------------------------
            */

                'referensi_type' =>
                'pembayaran',

                'referensi_id' =>
                $pembayaran->id_pembayaran,

                'id_admin' =>
                $adminId,

            ]);
        });


        /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

        return redirect()
            ->route(
                'angsuran.anggota',
                $angsuran->pinjaman->id_anggota
            )
            ->with(
                'success',
                'Pembayaran berhasil disimpan dan otomatis dicatat sebagai pemasukan.'
            );
    }


    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load([
            'angsuran.pinjaman.anggota',
            'admin',
        ]);

        return view(
            'pembayaran.show',
            compact('pembayaran')
        );
    }

    public function kuitansi(Pembayaran $pembayaran)
    {
        $pembayaran->load([
            'angsuran.pinjaman.anggota',
            'admin',
        ]);

        $pdf = Pdf::loadView(
            'pembayaran.kuitansi',
            compact('pembayaran')
        );

        $pdf->setPaper('A5', 'landscape');

        return $pdf->stream(
            'Kuitansi-' . $pembayaran->id_pembayaran . '.pdf'
        );
    }
}
