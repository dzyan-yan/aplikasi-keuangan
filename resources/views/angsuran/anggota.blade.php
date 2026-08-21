@extends('layouts.app')

@section('title', 'Detail Angsuran')

@section('page-title', 'Detail Angsuran')

@section('content')


{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Detail Angsuran
        </h3>

        <p class="text-muted mb-0">

            {{ $anggota->nama }}
            -
            {{ $anggota->kode_anggota }}

        </p>

    </div>


    <a
        href="{{ route(
            'angsuran.index',
            ['bulan' => $bulan]
        ) }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>


{{-- ========================================================= --}}
{{-- FILTER BULAN --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form
            method="GET"
            action="{{ route(
                'angsuran.anggota',
                $anggota->id_anggota
            ) }}">

            <div class="row g-3 align-items-end">

                <div class="col-md-4">

                    <label class="form-label">
                        Bulan Angsuran
                    </label>

                    <input
                        type="month"
                        name="bulan"
                        class="form-control"
                        value="{{ $bulan }}">

                </div>


                <div class="col-md-4">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-search me-1"></i>

                        Tampilkan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- INFORMASI ANGGOTA --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white">

        <h5 class="mb-0">

            <i class="bi bi-person-circle me-2"></i>

            Informasi Anggota

        </h5>

    </div>


    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-3">

                <small class="text-muted">
                    Kode Anggota
                </small>

                <div class="fw-bold">
                    {{ $anggota->kode_anggota }}
                </div>

            </div>


            <div class="col-md-3">

                <small class="text-muted">
                    Nama Anggota
                </small>

                <div class="fw-bold">
                    {{ $anggota->nama }}
                </div>

            </div>


            <div class="col-md-3">

                <small class="text-muted">
                    No. HP
                </small>

                <div class="fw-bold">
                    {{ $anggota->no_hp ?? '-' }}
                </div>

            </div>


            <div class="col-md-3">

                <small class="text-muted">
                    Periode
                </small>

                <div class="fw-bold text-primary">

                    {{ $awalBulan->translatedFormat('F Y') }}

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- RINGKASAN BULAN --}}
{{-- ========================================================= --}}

<div class="row g-3 mb-4">


    {{-- TOTAL ANGSURAN --}}
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">
                    Total Angsuran Bulan Ini
                </small>

                <h4 class="text-primary mb-0">

                    Rp {{ number_format(
                        $totalAngsuranBulanIni,
                        0,
                        ',',
                        '.'
                    ) }}

                </h4>

            </div>

        </div>

    </div>


    {{-- SUDAH DIBAYAR --}}
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">
                    Sudah Dibayar
                </small>

                <h4 class="text-success mb-0">

                    Rp {{ number_format(
                        $totalDibayarBulanIni,
                        0,
                        ',',
                        '.'
                    ) }}

                </h4>

            </div>

        </div>

    </div>


    {{-- SISA TAGIHAN --}}
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">
                    Sisa Tagihan
                </small>

                <h4 class="text-danger mb-0">

                    Rp {{ number_format(
                        $totalTagihanBulanIni,
                        0,
                        ',',
                        '.'
                    ) }}

                </h4>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- SELURUH PINJAMAN --}}
{{-- ========================================================= --}}

@forelse($anggota->pinjaman as $pinjaman)


@php

/*
|--------------------------------------------------------------------------
| Angsuran pinjaman pada bulan yang dipilih
|--------------------------------------------------------------------------
*/

$angsuranBulanIni = $pinjaman->angsuran
->filter(function ($angsuran) use (
$awalBulan,
$akhirBulan
) {

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
| Total dibayar pinjaman
|--------------------------------------------------------------------------
*/

$totalDibayarPinjaman = $pinjaman->angsuran
->sum('jumlah_dibayar');


/*
|--------------------------------------------------------------------------
| Sisa pinjaman
|--------------------------------------------------------------------------
*/

$sisaPinjaman = max(
0,
$pinjaman->total_pinjaman
- $totalDibayarPinjaman
);

@endphp


<div class="card border-0 shadow-sm mb-4">


    {{-- ================================================= --}}
    {{-- HEADER PINJAMAN --}}
    {{-- ================================================= --}}

    <div class="card-header bg-white">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="mb-1">

                    <i class="bi bi-cash-stack me-2"></i>

                    {{ $pinjaman->no_pinjaman }}

                </h5>


                <small class="text-muted">

                    Tanggal Pinjaman:

                    {{ \Carbon\Carbon::parse(
                            $pinjaman->tanggal_pinjaman
                        )->format('d-m-Y') }}

                </small>

            </div>


            {{-- STATUS --}}
            <div>

                @if($pinjaman->status === 'aktif')

                <span class="badge bg-primary">
                    Aktif
                </span>

                @elseif($pinjaman->status === 'lunas')

                <span class="badge bg-success">
                    Lunas
                </span>

                @elseif($pinjaman->status === 'dibatalkan')

                <span class="badge bg-danger">
                    Dibatalkan
                </span>

                @endif

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- BODY PINJAMAN --}}
    {{-- ================================================= --}}

    <div class="card-body">


        {{-- RINGKASAN PINJAMAN --}}

        <div class="row g-3 mb-4">


            <div class="col-md-3">

                <small class="text-muted">
                    Pokok Pinjaman
                </small>

                <div class="fw-bold">

                    Rp {{ number_format(
                            $pinjaman->jumlah_pinjaman,
                            0,
                            ',',
                            '.'
                        ) }}

                </div>

            </div>


            <div class="col-md-3">

                <small class="text-muted">
                    Total Pinjaman
                </small>

                <div class="fw-bold text-primary">

                    Rp {{ number_format(
                            $pinjaman->total_pinjaman,
                            0,
                            ',',
                            '.'
                        ) }}

                </div>

            </div>


            <div class="col-md-3">

                <small class="text-muted">
                    Angsuran / Periode
                </small>

                <div class="fw-bold text-success">

                    Rp {{ number_format(
                            $pinjaman->jumlah_angsuran,
                            0,
                            ',',
                            '.'
                        ) }}

                </div>

            </div>


            <div class="col-md-3">

                <small class="text-muted">
                    Sisa Pinjaman
                </small>

                <div class="fw-bold text-danger">

                    Rp {{ number_format(
                            $sisaPinjaman,
                            0,
                            ',',
                            '.'
                        ) }}

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- JADWAL BULAN INI --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-2">

            <h6 class="mb-0">

                <i class="bi bi-calendar-check me-2"></i>

                Angsuran
                {{ $awalBulan->translatedFormat('F Y') }}

            </h6>


            <span class="badge bg-primary">

                {{ $angsuranBulanIni->count() }}
                Angsuran

            </span>

        </div>


        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="70">
                            Ke
                        </th>

                        <th>
                            Jatuh Tempo
                        </th>

                        <th>
                            Tagihan
                        </th>

                        <th>
                            Dibayar
                        </th>

                        <th>
                            Sisa
                        </th>

                        <th>
                            Status
                        </th>

                        <th width="100">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($angsuranBulanIni as $angsuran)

                    @php

                    $sisa = max(
                    0,
                    $angsuran->jumlah_angsuran
                    + $angsuran->denda
                    - $angsuran->jumlah_dibayar
                    );

                    @endphp


                    <tr>


                        {{-- KE --}}
                        <td>

                            <strong>

                                {{ $angsuran->angsuran_ke }}

                            </strong>

                            /

                            {{ $pinjaman->tenor }}

                        </td>


                        {{-- JATUH TEMPO --}}
                        <td>

                            {{ \Carbon\Carbon::parse(
                                        $angsuran->jatuh_tempo
                                    )->format('d-m-Y') }}

                        </td>


                        {{-- TAGIHAN --}}
                        <td>

                            Rp {{ number_format(
                                        $angsuran->jumlah_angsuran,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                        </td>


                        {{-- DIBAYAR --}}
                        <td class="text-success">

                            Rp {{ number_format(
                                        $angsuran->jumlah_dibayar,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                        </td>


                        {{-- SISA --}}
                        <td>

                            <span
                                class="{{ $sisa > 0
                                            ? 'text-danger'
                                            : 'text-success' }}">

                                Rp {{ number_format(
                                            $sisa,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                            </span>

                        </td>


                        {{-- STATUS --}}
                        <td>

                            @if($angsuran->status === 'belum_bayar')

                            <span class="badge bg-secondary">
                                Belum Bayar
                            </span>

                            @elseif($angsuran->status === 'sebagian')

                            <span class="badge bg-warning text-dark">
                                Sebagian
                            </span>

                            @elseif($angsuran->status === 'lunas')

                            <span class="badge bg-success">
                                Lunas
                            </span>

                            @elseif($angsuran->status === 'terlambat')

                            <span class="badge bg-danger">
                                Terlambat
                            </span>

                            @endif

                        </td>


                        {{-- AKSI --}}
                        <td>

                            @if($angsuran->status !== 'lunas')
                            @if(in_array(session('admin_role'), ['superadmin', 'bendahara']))

                            <a
                                href="{{ route('angsuran.bayar', $angsuran) }}"
                                class="btn btn-sm btn-primary">

                                <i class="bi bi-cash-coin me-1"></i>

                                Bayar

                            </a>
                            @endif
                            @else

                            <span class="badge bg-success">

                                <i class="bi bi-check-circle me-1"></i>

                                Lunas

                            </span>

                            @endif

                        </td>


                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="7"
                            class="text-center text-muted py-4">

                            Tidak ada angsuran yang jatuh tempo
                            pada bulan
                            {{ $awalBulan->translatedFormat('F Y') }}.

                        </td>

                    </tr>

                    @endforelse


                </tbody>

            </table>


        </div>

    </div>

</div>

@empty


<div class="alert alert-info">

    Anggota ini belum memiliki pinjaman.

</div>


@endforelse

{{-- ========================================================= --}}
{{-- RIWAYAT PEMBAYARAN --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <strong>

                    <i class="bi bi-clock-history me-2"></i>

                    Riwayat Pembayaran

                </strong>

                <div class="small text-muted mt-1">

                    Seluruh transaksi pembayaran anggota

                </div>

            </div>

        </div>

    </div>


    <div class="card-body p-0">

        @php

        /*
        |--------------------------------------------------------------------------
        | Ambil seluruh pembayaran dari seluruh pinjaman anggota
        |--------------------------------------------------------------------------
        */

        $riwayatPembayaran = collect();

        foreach ($anggota->pinjaman as $pinjamanItem) {

        foreach ($pinjamanItem->angsuran as $angsuranItem) {

        foreach ($angsuranItem->pembayarans as $pembayaranItem) {

        $riwayatPembayaran->push(
        $pembayaranItem
        );

        }

        }

        }


        /*
        |--------------------------------------------------------------------------
        | Urutkan pembayaran terbaru
        |--------------------------------------------------------------------------
        */

        $riwayatPembayaran = $riwayatPembayaran
        ->sortByDesc('tanggal_bayar')
        ->values();

        @endphp


        @if($riwayatPembayaran->count() > 0)

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light text-center">

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            No. Pinjaman
                        </th>

                        <th>
                            Angsuran
                        </th>

                        <th>
                            Jumlah Bayar
                        </th>

                        <th>
                            Denda
                        </th>

                        <th>
                            Admin
                        </th>

                        <th width="100">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach(
                    $riwayatPembayaran
                    as $pembayaran
                    )

                    <tr>

                        {{-- NO --}}

                        <td>

                            {{ $loop->iteration }}

                        </td>


                        {{-- TANGGAL --}}

                        <td>

                            {{ \Carbon\Carbon::parse(
                                        $pembayaran->tanggal_bayar
                                    )->format('d-m-Y') }}

                        </td>


                        {{-- NO PINJAMAN --}}

                        <td>

                            <span class="fw-semibold">

                                {{ $pembayaran
                                            ->angsuran
                                            ->pinjaman
                                            ->no_pinjaman }}

                            </span>

                        </td>


                        {{-- ANGSURAN --}}

                        <td>

                            <span class="badge bg-primary">

                                Ke-

                                {{ $pembayaran
                                            ->angsuran
                                            ->angsuran_ke }}

                            </span>

                        </td>


                        {{-- JUMLAH BAYAR --}}

                        <td>

                            <strong class="text-success">

                                Rp
                                {{ number_format(
                                            $pembayaran->jumlah_bayar,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                            </strong>

                        </td>


                        {{-- DENDA --}}

                        <td>

                            @if($pembayaran->denda > 0)

                            <span class="text-danger">

                                Rp
                                {{ number_format(
                                                $pembayaran->denda,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                            </span>

                            @else

                            Rp 0

                            @endif

                        </td>


                        {{-- ADMIN --}}

                        <td>

                            {{ $pembayaran->admin->nama ?? '-' }}

                        </td>


                        {{-- DETAIL --}}

                        <td>

                        <td>

                            <div class="d-flex gap-1">

                                <a
                                    href="{{ route(
                'pembayaran.show',
                $pembayaran
            ) }}"
                                    class="btn btn-sm btn-info text-white">

                                    <i class="bi bi-eye me-1"></i>

                                    Detail

                                </a>


                                <a
                                    href="{{ route(
                'pembayaran.kuitansi',
                $pembayaran
            ) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-danger">

                                    <i class="bi bi-file-earmark-pdf"></i>

                                    Cetak PDF

                                </a>

                            </div>

                        </td>

                        </td>

                    </tr>

                    @endforeach

                </tbody>


                {{-- TOTAL --}}

                <tfoot class="table-light">

                    <tr>

                        <th colspan="4" class="text-end">

                            Total Pembayaran

                        </th>

                        <th class="text-success">

                            Rp
                            {{ number_format(
                                    $riwayatPembayaran->sum(
                                        'jumlah_bayar'
                                    ),
                                    0,
                                    ',',
                                    '.'
                                ) }}

                        </th>

                        <th class="text-danger">

                            Rp
                            {{ number_format(
                                    $riwayatPembayaran->sum(
                                        'denda'
                                    ),
                                    0,
                                    ',',
                                    '.'
                                ) }}

                        </th>

                        <th colspan="2"></th>

                    </tr>

                </tfoot>

            </table>

        </div>

        @else

        <div class="text-center py-5">

            <i
                class="bi bi-receipt fs-1 text-muted">
            </i>

            <p class="text-muted mt-3 mb-0">

                Belum ada riwayat pembayaran.

            </p>

        </div>

        @endif

    </div>

</div>

@endsection