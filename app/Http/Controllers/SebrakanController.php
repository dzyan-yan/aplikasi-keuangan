<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Sebrakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pemasukan;

class SebrakanController extends Controller
{
    /**
     * Daftar sebrakan
     */
    public function index()
    {
        $sebrakans = Sebrakan::with('anggota')
            ->orderByDesc('tanggal_sebrakan')
            ->orderByDesc('id_sebrakan')
            ->get();

        return view('sebrakan.index', compact('sebrakans'));
    }


    /**
     * Form tambah sebrakan
     */
    public function create()
    {
        $anggotas = Anggota::where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        return view('sebrakan.create', compact('anggotas'));
    }


    /**
     * Simpan sebrakan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'id_anggota' => [
                'required',
                'exists:anggotas,id_anggota',
            ],

            'tanggal_sebrakan' => [
                'required',
                'date',
            ],

            'pokok' => [
                'required',
                'numeric',
                'min:1',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | PERHITUNGAN SEBRAKAN
        |--------------------------------------------------------------------------
        */

        $pokok = (float) $validated['pokok'];

        // Bunga tetap 5%
        $bungaPersen = 5.00;

        // Hitung bunga
        $bunga = $pokok * ($bungaPersen / 100);

        // Total yang harus dibayar
        $total = $pokok + $bunga;


        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */

        $tanggalSebrakan = Carbon::parse(
            $validated['tanggal_sebrakan']
        );

        // 1 selapan = 35 hari
        $tanggalJatuhTempo = $tanggalSebrakan
            ->copy()
            ->addDays(35);


        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        Sebrakan::create([

            'id_anggota'          => $validated['id_anggota'],

            'tanggal_sebrakan'    => $tanggalSebrakan->format('Y-m-d'),

            'tanggal_jatuh_tempo' => $tanggalJatuhTempo->format('Y-m-d'),

            'pokok'               => $pokok,

            'bunga_persen'        => $bungaPersen,

            'bunga'               => $bunga,

            'total'               => $total,

            'jumlah_bayar'        => 0,

            'tanggal_bayar'       => null,

            'status'              => 'belum_lunas',

        ]);


        return redirect()
            ->route('sebrakan.index')
            ->with(
                'success',
                'Sebrakan berhasil ditambahkan.'
            );
    }


    /**
     * Detail sebrakan
     */
    public function show(Sebrakan $sebrakan)
    {
        $sebrakan->load('anggota');

        return view(
            'sebrakan.show',
            compact('sebrakan')
        );
    }

    /**
     * Pembayaran sekaligus sampai lunas.
     */
    public function bayar(Request $request, Sebrakan $sebrakan)
    {
        if ($sebrakan->status === 'lunas') {
            return back()->with('error', 'Sebrakan ini sudah lunas.');
        }

        $validated = $request->validate([
            'tanggal_bayar' => [
                'required',
                'date',
            ],
        ]);

        DB::transaction(function () use ($sebrakan, $validated) {

            // 1. Lunasi sebrakan
            $sebrakan->update([
                'jumlah_bayar'  => $sebrakan->total,
                'tanggal_bayar' => $validated['tanggal_bayar'],
                'status'        => 'lunas',
            ]);

            // 2. Masukkan otomatis ke pemasukan
            \App\Models\Pemasukan::create([
                'tanggal'         => $validated['tanggal_bayar'],
                'kategori'        => 'Sebrakan',
                'sumber'          => 'Pembayaran Sebrakan',
                'keterangan'     => 'Pelunasan sebrakan anggota '
                    . $sebrakan->anggota->nama,
                'jumlah'          => $sebrakan->total,
                'referensi_type'  => 'Sebrakan',
                'referensi_id'    => $sebrakan->id_sebrakan,
                'id_admin'        => session('admin_id'),
            ]);
        });

        return redirect()
            ->route('sebrakan.index')
            ->with(
                'success',
                'Sebrakan berhasil dilunasi dan dicatat sebagai pemasukan.'
            );
    }
}
