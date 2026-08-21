<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================================================
        // PERIODE BULAN INI
        // =====================================================

        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();

        $bulan = Carbon::now()->format('Y-m');


        // =====================================================
        // ANGGOTA
        // =====================================================

        $totalAnggota = Anggota::count();

        $anggotaAktif = Anggota::where(
            'status',
            'aktif'
        )->count();

        $anggotaNonaktif = Anggota::where(
            'status',
            'nonaktif'
        )->count();


        // =====================================================
        // PINJAMAN
        // =====================================================

        $totalPinjaman = Pinjaman::count();

        $pinjamanAktif = Pinjaman::where(
            'status',
            'aktif'
        )->count();

        $pinjamanLunas = Pinjaman::where(
            'status',
            'lunas'
        )->count();

        $totalNilaiPinjaman = Pinjaman::sum(
            'total_pinjaman'
        );


        // =====================================================
        // ANGSURAN BULAN INI
        // =====================================================

        $totalAngsuran = Angsuran::whereBetween(
            'jatuh_tempo',
            [
                $awalBulan->toDateString(),
                $akhirBulan->toDateString()
            ]
        )->sum('jumlah_angsuran');


        // =====================================================
        // PEMBAYARAN ANGSURAN BULAN INI
        // =====================================================

        $totalPembayaranAngsuran = Pembayaran::whereBetween(
            'tanggal_bayar',
            [
                $awalBulan->toDateString(),
                $akhirBulan->toDateString()
            ]
        )->sum('jumlah_bayar');


        // =====================================================
        // ANGSURAN BELUM BAYAR
        // =====================================================

        $angsuranBelumBayar = Angsuran::whereIn(
            'status',
            [
                'belum_bayar',
                'sebagian',
                'terlambat'
            ]
        )->count();


        // =====================================================
        // PEMASUKAN BULAN INI
        // =====================================================

        $totalPemasukan = Pemasukan::whereBetween(
            'tanggal',
            [
                $awalBulan->toDateString(),
                $akhirBulan->toDateString()
            ]
        )->sum('jumlah');


        // =====================================================
        // PENGELUARAN BULAN INI
        // =====================================================

        $totalPengeluaran = Pengeluaran::whereBetween(
            'tanggal',
            [
                $awalBulan->toDateString(),
                $akhirBulan->toDateString()
            ]
        )->sum('jumlah');


        // =====================================================
        // SALDO / LABA BERSIH BULAN INI
        // =====================================================

        $saldoBulanIni =
            $totalPemasukan
            - $totalPengeluaran;


        // =====================================================
        // TOTAL KEUANGAN KESELURUHAN
        // =====================================================

        $totalPemasukanKeseluruhan =
            Pemasukan::sum('jumlah');

        $totalPengeluaranKeseluruhan =
            Pengeluaran::sum('jumlah');

        $saldoKeseluruhan =
            $totalPemasukanKeseluruhan
            - $totalPengeluaranKeseluruhan;


        // =====================================================
        // PEMASUKAN PER KATEGORI BULAN INI
        // =====================================================

        $pemasukanKategori = Pemasukan::whereBetween(
            'tanggal',
            [
                $awalBulan->toDateString(),
                $akhirBulan->toDateString()
            ]
        )
            ->selectRaw(
                'kategori, SUM(jumlah) as total'
            )
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();


        // =====================================================
        // PENGELUARAN PER KATEGORI BULAN INI
        // =====================================================

        $pengeluaranKategori = Pengeluaran::whereBetween(
            'tanggal',
            [
                $awalBulan->toDateString(),
                $akhirBulan->toDateString()
            ]
        )
            ->selectRaw(
                'kategori, SUM(jumlah) as total'
            )
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();


        // =====================================================
        // PEMASUKAN 12 BULAN
        // =====================================================

        $pemasukanBulanan = [];

        $pengeluaranBulanan = [];

        $labelBulan = [];


        for ($i = 11; $i >= 0; $i--) {

            $tanggal = Carbon::now()
                ->subMonths($i);

            $tahun = $tanggal->year;

            $bulanAngka = $tanggal->month;


            $labelBulan[] =
                $tanggal->translatedFormat('M');


            $pemasukanBulanan[] =
                Pemasukan::whereYear(
                    'tanggal',
                    $tahun
                )
                ->whereMonth(
                    'tanggal',
                    $bulanAngka
                )
                ->sum('jumlah');


            $pengeluaranBulanan[] =
                Pengeluaran::whereYear(
                    'tanggal',
                    $tahun
                )
                ->whereMonth(
                    'tanggal',
                    $bulanAngka
                )
                ->sum('jumlah');
        }


        // =====================================================
        // ANGSURAN STATUS
        // =====================================================

        $angsuranLunas = Angsuran::where(
            'status',
            'lunas'
        )->count();

        $angsuranSebagian = Angsuran::where(
            'status',
            'sebagian'
        )->count();

        $angsuranBelum = Angsuran::where(
            'status',
            'belum_bayar'
        )->count();

        $angsuranTerlambat = Angsuran::where(
            'status',
            'terlambat'
        )->count();


        // =====================================================
        // DATA ANGSURAN JATUH TEMPO BULAN INI
        // =====================================================

        $angsuranJatuhTempo = Angsuran::with([
            'pinjaman.anggota'
        ])
            ->whereBetween(
                'jatuh_tempo',
                [
                    $awalBulan->toDateString(),
                    $akhirBulan->toDateString()
                ]
            )
            ->orderBy(
                'jatuh_tempo'
            )
            ->get();


        // =====================================================
        // DATA PEMBAYARAN TERBARU
        // =====================================================

        $pembayaranTerbaru = Pembayaran::with([
            'angsuran.pinjaman.anggota',
            'admin'
        ])
            ->latest(
                'tanggal_bayar'
            )
            ->latest(
                'id_pembayaran'
            )
            ->limit(10)
            ->get();


        // =====================================================
        // PEMASUKAN TERBARU
        // =====================================================

        $pemasukanTerbaru = Pemasukan::with([
            'admin'
        ])
            ->latest('tanggal')
            ->latest('id_pemasukan')
            ->limit(10)
            ->get();


        // =====================================================
        // PENGELUARAN TERBARU
        // =====================================================

        $pengeluaranTerbaru = Pengeluaran::with([
            'admin'
        ])
            ->latest('tanggal')
            ->latest('id_pengeluaran')
            ->limit(10)
            ->get();


        $bulanLabels = [];

        $pemasukanBulanan = [];

        $pengeluaranBulanan = [];

        for ($i = 1; $i <= 12; $i++) {

            $bulanLabels[] = Carbon::create()
                ->month($i)
                ->translatedFormat('M');

            $pemasukanBulanan[] = Pemasukan::whereYear(
                'tanggal',
                now()->year
            )
                ->whereMonth('tanggal', $i)
                ->sum('jumlah');

            $pengeluaranBulanan[] = Pengeluaran::whereYear(
                'tanggal',
                now()->year
            )
                ->whereMonth('tanggal', $i)
                ->sum('jumlah');
        }

        // =====================================================
        // KIRIM KE VIEW
        // =====================================================

        return view(
            'dashboard.index',
            compact(

                // periode
                'awalBulan',
                'akhirBulan',
                'bulan',

                // anggota
                'totalAnggota',
                'anggotaAktif',
                'anggotaNonaktif',

                // pinjaman
                'totalPinjaman',
                'pinjamanAktif',
                'pinjamanLunas',
                'totalNilaiPinjaman',

                // angsuran
                'totalAngsuran',
                'totalPembayaranAngsuran',
                'angsuranBelumBayar',
                'angsuranLunas',
                'angsuranSebagian',
                'angsuranBelum',
                'angsuranTerlambat',
                'angsuranJatuhTempo',

                // keuangan
                'totalPemasukan',
                'totalPengeluaran',
                'saldoBulanIni',

                'totalPemasukanKeseluruhan',
                'totalPengeluaranKeseluruhan',
                'saldoKeseluruhan',

                // kategori
                'pemasukanKategori',
                'pengeluaranKategori',

                // grafik
                'labelBulan',
                'pemasukanBulanan',
                'pengeluaranBulanan',

                // transaksi terbaru
                'pembayaranTerbaru',
                'pemasukanTerbaru',
                'pengeluaranTerbaru',


                'bulanLabels',
                'pemasukanBulanan',
                'pengeluaranBulanan',


            )
        );
    }
}
