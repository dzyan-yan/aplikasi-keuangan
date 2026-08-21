<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Exports\PemasukanExport;
use Maatwebsite\Excel\Facades\Excel;


class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun ?? date('Y');
        $kategori = $request->kategori;


        /*
    |--------------------------------------------------------------------------
    | Query utama
    |--------------------------------------------------------------------------
    */

        $query = Pemasukan::with('admin')
            ->orderByDesc('tanggal')
            ->orderByDesc('id_pemasukan');


        /*
    |--------------------------------------------------------------------------
    | Filter bulan
    |--------------------------------------------------------------------------
    */

        if ($bulan) {

            $query->whereMonth(
                'tanggal',
                $bulan
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Filter tahun
    |--------------------------------------------------------------------------
    */

        if ($tahun) {

            $query->whereYear(
                'tanggal',
                $tahun
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Filter kategori
    |--------------------------------------------------------------------------
    */

        if ($kategori) {

            $query->where(
                'kategori',
                $kategori
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Data pemasukan
    |--------------------------------------------------------------------------
    */

        $pemasukans = $query->get();


        /*
    |--------------------------------------------------------------------------
    | Total berdasarkan filter
    |--------------------------------------------------------------------------
    */

        $totalFilter =
            $pemasukans->sum('jumlah');


        /*
    |--------------------------------------------------------------------------
    | Total pemasukan
    |--------------------------------------------------------------------------
    */

        $totalPemasukan =
            $pemasukans->sum('jumlah');


        /*
    |--------------------------------------------------------------------------
    | Total angsuran
    |--------------------------------------------------------------------------
    */

        $totalAngsuran =
            $pemasukans
            ->where('kategori', 'Angsuran')
            ->sum('jumlah');


        /*
    |--------------------------------------------------------------------------
    | Total pemasukan lainnya
    |--------------------------------------------------------------------------
    */

        $totalLainnya =
            $totalPemasukan
            - $totalAngsuran;


        /*
    |--------------------------------------------------------------------------
    | Daftar kategori
    |--------------------------------------------------------------------------
    */

        $daftarKategori =
            Pemasukan::query()
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');


        /*
    |--------------------------------------------------------------------------
    | Daftar tahun
    |--------------------------------------------------------------------------
    */

        $daftarTahun =
            Pemasukan::query()
            ->selectRaw(
                'YEAR(tanggal) as tahun'
            )
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');


        /*
    |--------------------------------------------------------------------------
    | Jika belum ada data
    |--------------------------------------------------------------------------
    */

        if ($daftarTahun->isEmpty()) {

            $daftarTahun =
                collect([
                    date('Y')
                ]);
        }


        return view(
            'pemasukan.index',
            compact(
                'pemasukans',
                'bulan',
                'tahun',
                'kategori',
                'totalPemasukan',
                'totalAngsuran',
                'totalLainnya',
                'totalFilter',
                'daftarKategori',
                'daftarTahun'
            )
        );
    }


    /**
     * Form tambah pemasukan
     */
    public function create()
    {
        return view('pemasukan.create');
    }


    /**
     * Simpan pemasukan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => [
                'required',
                'date',
            ],

            'kategori' => [
                'required',
                'string',
                'max:100',
            ],

            'sumber' => [
                'nullable',
                'string',
                'max:150',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:255',
            ],

            'jumlah' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);


        Pemasukan::create([
            'tanggal' => $validated['tanggal'],
            'kategori' => $validated['kategori'],
            'sumber' => $validated['sumber'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'jumlah' => $validated['jumlah'],

            // Pemasukan manual
            'referensi_type' => null,
            'referensi_id' => null,

            // Admin yang sedang login
            'id_admin' => session('admin_id'),
        ]);


        return redirect()
            ->route('pemasukan.index')
            ->with(
                'success',
                'Pemasukan berhasil ditambahkan.'
            );
    }


    /**
     * Detail pemasukan
     */
    public function show(Pemasukan $pemasukan)
    {
        $pemasukan->load('admin');

        return view(
            'pemasukan.show',
            compact('pemasukan')
        );
    }


    /**
     * Form edit
     */
    public function edit(Pemasukan $pemasukan)
    {
        return view(
            'pemasukan.edit',
            compact('pemasukan')
        );
    }


    /**
     * Update pemasukan
     */
    public function update(
        Request $request,
        Pemasukan $pemasukan
    ) {
        // Jangan izinkan transaksi otomatis
        // diedit dari modul pemasukan.
        if ($pemasukan->referensi_type !== null) {

            return redirect()
                ->route(
                    'pemasukan.show',
                    $pemasukan
                )
                ->with(
                    'error',
                    'Pemasukan dari transaksi otomatis tidak dapat diedit dari modul ini.'
                );
        }


        $validated = $request->validate([
            'tanggal' => [
                'required',
                'date',
            ],

            'kategori' => [
                'required',
                'string',
                'max:100',
            ],

            'sumber' => [
                'nullable',
                'string',
                'max:150',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:255',
            ],

            'jumlah' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);


        $pemasukan->update([
            'tanggal' => $validated['tanggal'],
            'kategori' => $validated['kategori'],
            'sumber' => $validated['sumber'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'jumlah' => $validated['jumlah'],
        ]);


        return redirect()
            ->route(
                'pemasukan.show',
                $pemasukan
            )
            ->with(
                'success',
                'Pemasukan berhasil diperbarui.'
            );
    }


    /**
     * Hapus pemasukan
     */
    public function destroy(Pemasukan $pemasukan)
    {
        // Jangan izinkan transaksi otomatis
        // dihapus secara manual.
        if ($pemasukan->referensi_type !== null) {

            return redirect()
                ->route('pemasukan.index')
                ->with(
                    'error',
                    'Pemasukan otomatis tidak dapat dihapus dari modul ini.'
                );
        }


        $pemasukan->delete();


        return redirect()
            ->route('pemasukan.index')
            ->with(
                'success',
                'Pemasukan berhasil dihapus.'
            );
    }

    public function export(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kategori = $request->kategori;

        $namaFile = 'laporan-pemasukan';

        if ($bulan) {
            $namaFile .= '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT);
        }

        if ($tahun) {
            $namaFile .= '-' . $tahun;
        }

        $namaFile .= '.xlsx';

        return Excel::download(
            new PemasukanExport(
                $bulan,
                $tahun,
                $kategori
            ),
            $namaFile
        );
    }
}
