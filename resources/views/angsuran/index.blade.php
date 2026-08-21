@extends('layouts.app')

@section('title', 'Angsuran')

@section('page-title', 'Angsuran')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Angsuran
        </h3>

        <p class="text-muted mb-0">
            Daftar anggota dan tagihan angsuran berdasarkan bulan.
        </p>

    </div>

</div>


{{-- ========================================================= --}}
{{-- FILTER --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form
            method="GET"
            action="{{ route('angsuran.index') }}">

            <div class="row g-3 align-items-end">

                {{-- BULAN --}}
                <div class="col-md-3">

                    <label class="form-label">
                        Bulan Angsuran
                    </label>

                    <input
                        type="month"
                        name="bulan"
                        class="form-control"
                        value="{{ $bulan }}">

                </div>


                {{-- SEARCH --}}
                <div class="col-md-6">

                    <label class="form-label">
                        Cari Anggota
                    </label>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Nama atau kode anggota..."
                        value="{{ request('search') }}">

                </div>


                {{-- BUTTON --}}
                <div class="col-md-3">

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>

                            Tampilkan

                        </button>


                        <a
                            href="{{ route('angsuran.index') }}"
                            class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- INFORMASI BULAN --}}
{{-- ========================================================= --}}

<div class="alert alert-info border-0 shadow-sm">

    <i class="bi bi-calendar3 me-2"></i>

    Menampilkan angsuran yang jatuh tempo pada:

    <strong>
        {{ $awalBulan->translatedFormat('F Y') }}
    </strong>

</div>


{{-- ========================================================= --}}
{{-- DAFTAR ANGGOTA --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white">

        <div class="d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="bi bi-people me-2"></i>

                Daftar Tagihan Anggota

            </h5>


            <span class="badge bg-primary">

                {{ $anggotas->total() }} Anggota

            </span>

        </div>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="50">
                            No
                        </th>

                        <th>
                            Anggota
                        </th>

                        <th>
                            Jumlah Pinjaman
                        </th>

                        <th>
                            Total Angsuran
                        </th>

                        <th>
                            Total Dibayar
                        </th>

                        <th>
                            Total Tagihan
                        </th>

                        <th width="120">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($anggotas as $anggota)

                    @php

                    /*
                    |--------------------------------------------------------------------------
                    | Semua angsuran dari seluruh pinjaman anggota
                    |--------------------------------------------------------------------------
                    */

                    $semuaAngsuran = $anggota->pinjaman
                    ->flatMap(function ($pinjaman) {
                    return $pinjaman->angsuran;
                    });


                    /*
                    |--------------------------------------------------------------------------
                    | Angsuran bulan yang dipilih
                    |--------------------------------------------------------------------------
                    */

                    $angsuranBulanIni = $semuaAngsuran
                    ->filter(function ($angsuran) use ($awalBulan, $akhirBulan) {

                    $jatuhTempo = \Carbon\Carbon::parse(
                    $angsuran->jatuh_tempo
                    );

                    return $jatuhTempo->between(
                    $awalBulan,
                    $akhirBulan
                    );

                    });


                    /*
                    |--------------------------------------------------------------------------
                    | Total jadwal angsuran bulan ini
                    |--------------------------------------------------------------------------
                    */

                    $totalAngsuran = $angsuranBulanIni
                    ->sum('jumlah_angsuran');


                    /*
                    |--------------------------------------------------------------------------
                    | Total yang sudah dibayar bulan ini
                    |--------------------------------------------------------------------------
                    */

                    $totalDibayar = $angsuranBulanIni
                    ->sum('jumlah_dibayar');


                    /*
                    |--------------------------------------------------------------------------
                    | Total sisa tagihan bulan ini
                    |--------------------------------------------------------------------------
                    */

                    $totalTagihan = $angsuranBulanIni
                    ->sum(function ($angsuran) {

                    return max(
                    0,
                    $angsuran->jumlah_angsuran
                    + $angsuran->denda
                    - $angsuran->jumlah_dibayar
                    );

                    });


                    /*
                    |--------------------------------------------------------------------------
                    | Jumlah pinjaman aktif
                    |--------------------------------------------------------------------------
                    */

                    $jumlahPinjaman = $anggota->pinjaman
                    ->where('status', 'aktif')
                    ->count();

                    @endphp


                    <tr>

                        <td>

                            {{ $anggotas->firstItem() + $loop->index }}

                        </td>


                        {{-- ANGGOTA --}}
                        <td>

                            <a
                                href="{{ route(
                                        'angsuran.anggota',
                                        [
                                            'anggota' => $anggota->id_anggota,
                                            'bulan' => $bulan
                                        ]
                                    ) }}"
                                class="text-decoration-none">

                                <strong>
                                    {{ $anggota->nama }}
                                </strong>

                            </a>

                            <br>

                            <small class="text-muted">

                                {{ $anggota->kode_anggota }}

                            </small>

                        </td>


                        {{-- JUMLAH PINJAMAN --}}
                        <td>

                            <span class="badge bg-primary">

                                {{ $jumlahPinjaman }}

                            </span>

                            pinjaman

                        </td>


                        {{-- TOTAL ANGSURAN --}}
                        <td>

                            <strong class="text-primary">

                                Rp {{ number_format(
                                        $totalAngsuran,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                            </strong>

                        </td>


                        {{-- TOTAL DIBAYAR --}}
                        <td>

                            <span class="text-success">

                                Rp {{ number_format(
                                        $totalDibayar,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                            </span>

                        </td>


                        {{-- TOTAL TAGIHAN --}}
                        <td>

                            <strong class="text-danger">

                                Rp {{ number_format(
                                        $totalTagihan,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                            </strong>

                        </td>


                        {{-- AKSI --}}
                        <td>

                            <a
                                href="{{ route(
                                        'angsuran.anggota',
                                        [
                                            'anggota' => $anggota->id_anggota,
                                            'bulan' => $bulan
                                        ]
                                    ) }}"
                                class="btn btn-sm btn-primary">

                                <i class="bi bi-eye me-1"></i>

                                Lihat

                            </a>

                        </td>

                    </tr>


                    @empty

                    <tr>

                        <td
                            colspan="7"
                            class="text-center py-5 text-muted">

                            <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>

                            Tidak ada anggota yang memiliki
                            angsuran pada bulan ini.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        <div class="mt-3">

            {{ $anggotas->links() }}

        </div>

    </div>

</div>

@endsection