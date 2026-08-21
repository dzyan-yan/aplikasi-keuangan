<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AngsuranController extends Controller
{
    /**
     * Daftar anggota dan total angsuran berdasarkan bulan.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Bulan yang dipilih
        |--------------------------------------------------------------------------
        | Format: YYYY-MM
        | Jika tidak ada filter, gunakan bulan sekarang.
        */

        $bulan = $request->input(
            'bulan',
            now()->format('Y-m')
        );

        /*
        |--------------------------------------------------------------------------
        | Validasi format bulan
        |--------------------------------------------------------------------------
        */

        try {

            $tanggalBulan = Carbon::createFromFormat(
                'Y-m',
                $bulan
            )->startOfMonth();
        } catch (\Exception $e) {

            $tanggalBulan = now()->startOfMonth();

            $bulan = $tanggalBulan->format('Y-m');
        }

        $awalBulan = $tanggalBulan->copy()->startOfMonth();
        $akhirBulan = $tanggalBulan->copy()->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | Ambil anggota yang mempunyai pinjaman
        |--------------------------------------------------------------------------
        */

        $query = Anggota::whereHas('pinjaman', function ($query) {

            $query->where('status', '!=', 'dibatalkan');
        })
            ->with([
                'pinjaman' => function ($query) {

                    $query->where('status', '!=', 'dibatalkan')
                        ->with('angsuran');
                }
            ]);


        /*
        |--------------------------------------------------------------------------
        | Pencarian anggota
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama',
                    'like',
                    '%' . $search . '%'
                )

                    ->orWhere(
                        'kode_anggota',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }


        $anggotas = $query
            ->orderBy('nama')
            ->paginate(20)
            ->withQueryString();


        return view(
            'angsuran.index',
            compact(
                'anggotas',
                'bulan',
                'awalBulan',
                'akhirBulan'
            )
        );
    }


    /**
     * Detail angsuran anggota berdasarkan bulan.
     */
    public function anggota(
        Request $request,
        Anggota $anggota
    ) {

        /*
        |--------------------------------------------------------------------------
        | Bulan yang dipilih
        |--------------------------------------------------------------------------
        */

        $bulan = $request->input(
            'bulan',
            now()->format('Y-m')
        );


        try {

            $tanggalBulan = Carbon::createFromFormat(
                'Y-m',
                $bulan
            )->startOfMonth();
        } catch (\Exception $e) {

            $tanggalBulan = now()->startOfMonth();

            $bulan = $tanggalBulan->format('Y-m');
        }


        $awalBulan = $tanggalBulan->copy()->startOfMonth();
        $akhirBulan = $tanggalBulan->copy()->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | Ambil seluruh pinjaman anggota
        |--------------------------------------------------------------------------
        */

        $anggota->load([
            'pinjaman' => function ($query) {

                $query->where(
                    'status',
                    '!=',
                    'dibatalkan'
                )
                    ->orderByDesc('tanggal_pinjaman');
            },

            'pinjaman.angsuran' => function ($query) {

                $query->orderBy('angsuran_ke');
            }
        ]);


        /*
        |--------------------------------------------------------------------------
        | Total angsuran bulan yang dipilih
        |--------------------------------------------------------------------------
        */

        $totalAngsuranBulanIni = 0;

        $totalTagihanBulanIni = 0;

        $totalDibayarBulanIni = 0;


        foreach ($anggota->pinjaman as $pinjaman) {

            foreach ($pinjaman->angsuran as $angsuran) {

                $jatuhTempo = Carbon::parse(
                    $angsuran->jatuh_tempo
                );


                if (
                    $jatuhTempo->between(
                        $awalBulan,
                        $akhirBulan
                    )
                ) {

                    /*
                    | Total jadwal angsuran
                    */

                    $totalAngsuranBulanIni +=
                        $angsuran->jumlah_angsuran;


                    /*
                    | Total pembayaran pada angsuran
                    */

                    $totalDibayarBulanIni +=
                        $angsuran->jumlah_dibayar;


                    /*
                    | Sisa tagihan
                    */

                    $sisa =

                        $angsuran->jumlah_angsuran
                        + $angsuran->denda
                        - $angsuran->jumlah_dibayar;


                    if ($sisa > 0) {

                        $totalTagihanBulanIni += $sisa;
                    }
                }
            }
        }


        return view(
            'angsuran.anggota',
            compact(
                'anggota',
                'bulan',
                'awalBulan',
                'akhirBulan',
                'totalAngsuranBulanIni',
                'totalTagihanBulanIni',
                'totalDibayarBulanIni'
            )
        );
    }
}
