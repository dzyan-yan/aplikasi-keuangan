<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Exports\PengeluaranExport;
use Maatwebsite\Excel\Facades\Excel;

class PengeluaranController extends Controller
{

    public function index(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | Nilai Filter
    |--------------------------------------------------------------------------
    */

        $bulan = $request->bulan;
        $tahun = $request->tahun ?? date('Y');
        $kategoriFilter = $request->kategori;
        $search = $request->search;


        /*
    |--------------------------------------------------------------------------
    | Query Utama
    |--------------------------------------------------------------------------
    */

        $query = Pengeluaran::with('admin')
            ->orderByDesc('tanggal')
            ->orderByDesc('id_pengeluaran');


        /*
    |--------------------------------------------------------------------------
    | Filter Bulan
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
    | Filter Tahun
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
    | Filter Kategori
    |--------------------------------------------------------------------------
    */

        if ($kategoriFilter) {

            $query->where(
                'kategori',
                $kategoriFilter
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Pencarian
    |--------------------------------------------------------------------------
    */

        if ($search) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'kategori',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'keperluan',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'keterangan',
                        'like',
                        "%{$search}%"
                    );
            });
        }


        /*
    |--------------------------------------------------------------------------
    | Data Pengeluaran
    |--------------------------------------------------------------------------
    */

        $pengeluarans = $query
            ->paginate(15)
            ->withQueryString();


        /*
    |--------------------------------------------------------------------------
    | Total Pengeluaran Sesuai Filter
    |--------------------------------------------------------------------------
    */

        $totalPengeluaran = (clone $query)
            ->sum('jumlah');


        /*
    |--------------------------------------------------------------------------
    | Daftar Kategori
    |--------------------------------------------------------------------------
    */

        $kategori = Pengeluaran::query()
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');


        /*
    |--------------------------------------------------------------------------
    | Daftar Tahun
    |--------------------------------------------------------------------------
    */

        $daftarTahun = Pengeluaran::query()
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');


        /*
    |--------------------------------------------------------------------------
    | Jika belum ada data tahun
    |--------------------------------------------------------------------------
    */

        if ($daftarTahun->isEmpty()) {

            $daftarTahun = collect([
                date('Y')
            ]);
        }


        /*
    |--------------------------------------------------------------------------
    | Kirim ke View
    |--------------------------------------------------------------------------
    */

        return view(
            'pengeluaran.index',
            compact(
                'pengeluarans',
                'totalPengeluaran',
                'kategori',
                'bulan',
                'tahun',
                'kategoriFilter',
                'search',
                'daftarTahun'
            )
        );
    }




    /**
     * Form tambah
     */
    public function create()
    {
        return view('pengeluaran.create');
    }


    /**
     * Simpan pengeluaran
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

            'keperluan' => [
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
                'min:1',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin Login
        |--------------------------------------------------------------------------
        */

        $validated['id_admin'] = session('admin_id');

        Pengeluaran::create($validated);

        return redirect()
            ->route('pengeluaran.index')
            ->with(
                'success',
                'Pengeluaran berhasil ditambahkan.'
            );
    }


    /**
     * Detail
     */
    public function show(Pengeluaran $pengeluaran)
    {
        $pengeluaran->load('admin');

        return view(
            'pengeluaran.show',
            compact('pengeluaran')
        );
    }


    /**
     * Form edit
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        return view(
            'pengeluaran.edit',
            compact('pengeluaran')
        );
    }


    /**
     * Update
     */
    public function update(
        Request $request,
        Pengeluaran $pengeluaran
    ) {

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

            'keperluan' => [
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
                'min:1',
            ],

        ]);

        $pengeluaran->update($validated);

        return redirect()
            ->route('pengeluaran.index')
            ->with(
                'success',
                'Pengeluaran berhasil diperbarui.'
            );
    }


    /**
     * Hapus
     */
    public function destroy(Pengeluaran $pengeluaran)
    {

        $pengeluaran->delete();

        return redirect()
            ->route('pengeluaran.index')
            ->with(
                'success',
                'Pengeluaran berhasil dihapus.'
            );
    }


    public function export(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $namaFile = 'laporan-pengeluaran';

        if ($bulan) {
            $namaFile .= '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT);
        }

        if ($tahun) {
            $namaFile .= '-' . $tahun;
        }

        $namaFile .= '.xlsx';

        return Excel::download(
            new PengeluaranExport(
                $bulan,
                $tahun
            ),
            $namaFile
        );
    }
}
