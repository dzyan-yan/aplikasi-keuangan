<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Menampilkan daftar anggota
     */
    public function index()
    {
        $anggotas = Anggota::orderBy('id_anggota', 'desc')->get();

        return view('anggota.index', compact('anggotas'));
    }

    /**
     * Form tambah anggota
     */
    public function create()
    {
        return view('anggota.create');
    }

    /**
     * Simpan anggota baru
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:30',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_daftar' => 'nullable|date',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Generate Kode Anggota Otomatis
    |--------------------------------------------------------------------------
    */

        $lastKode = Anggota::orderByDesc('kode_anggota')
            ->value('kode_anggota');

        if ($lastKode) {

            // Ambil angka dari AGT001
            $angka = (int) preg_replace('/[^0-9]/', '', $lastKode);

            $angka++;
        } else {

            $angka = 1;
        }

        $kodeAnggota = 'AGT' . str_pad($angka, 3, '0', STR_PAD_LEFT);


        /*
    |--------------------------------------------------------------------------
    | Simpan Anggota
    |--------------------------------------------------------------------------
    */

        Anggota::create([
            'kode_anggota'   => $kodeAnggota,
            'nama'           => $validated['nama'],
            'nik'            => $validated['nik'] ?? null,
            'no_hp'          => $validated['no_hp'] ?? null,
            'alamat'         => $validated['alamat'] ?? null,
            'tanggal_daftar' => $validated['tanggal_daftar'] ?? now()->format('Y-m-d'),
            'status'         => $validated['status'],
        ]);

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan dengan kode ' . $kodeAnggota);
    }

    /**
     * Detail anggota
     */
    public function show(Anggota $anggota)
    {
        return view('anggota.show', compact('anggota'));
    }

    /**
     * Form edit anggota
     */
    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', compact('anggota'));
    }

    /**
     * Update anggota
     */
    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([

            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'nik' => [
                'nullable',
                'string',
                'max:20',
            ],

            'no_hp' => [
                'nullable',
                'string',
                'max:20',
            ],

            'alamat' => [
                'nullable',
                'string',
            ],

            'tanggal_daftar' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'in:aktif,nonaktif',
            ],

        ]);

        $anggota->update($validated);

        return redirect()
            ->route('anggota.show', $anggota)
            ->with(
                'success',
                'Data anggota berhasil diperbarui.'
            );
    }

    /**
     * Hapus anggota
     */
    public function destroy(Anggota $anggota)
    {
        $anggota->delete();

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
