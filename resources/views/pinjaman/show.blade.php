@extends('layouts.app')

@section('title', 'Detail Pinjaman')

@section('page-title', 'Detail Pinjaman')

@section('content')

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">Detail Pinjaman</h3>

        <p class="text-muted mb-0">
            Informasi pinjaman dan jadwal angsuran.
        </p>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('pinjaman.index') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Kembali

        </a>

    </div>

</div>


{{-- INFORMASI PINJAMAN --}}
<div class="row g-3 mb-4">

    {{-- IDENTITAS PINJAMAN --}}
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <h5 class="mb-0">
                    <i class="bi bi-cash-stack me-2"></i>
                    Informasi Pinjaman
                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <small class="text-muted">
                            No. Pinjaman
                        </small>

                        <div class="fw-bold">
                            {{ $pinjaman->no_pinjaman }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <small class="text-muted">
                            Tanggal Pinjaman
                        </small>

                        <div class="fw-bold">

                            {{ $pinjaman->tanggal_pinjaman
                                ? $pinjaman->tanggal_pinjaman->format('d-m-Y')
                                : '-'
                            }}

                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <small class="text-muted">
                            Anggota
                        </small>

                        <div class="fw-bold">

                            {{ $pinjaman->anggota->nama ?? '-' }}

                        </div>

                        @if($pinjaman->anggota)

                        <small class="text-muted">

                            {{ $pinjaman->anggota->kode_anggota }}

                        </small>

                        @endif

                    </div>


                    <div class="col-md-6 mb-3">

                        <small class="text-muted">
                            Status Pinjaman
                        </small>

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

                            <span class="badge bg-secondary">
                                Dibatalkan
                            </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- RINGKASAN --}}
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <h5 class="mb-0">
                    <i class="bi bi-calculator me-2"></i>
                    Ringkasan
                </h5>

            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <span class="text-muted">
                        Pokok Pinjaman
                    </span>

                    <strong>
                        Rp {{ number_format(
                            $pinjaman->jumlah_pinjaman,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>


                <div class="d-flex justify-content-between mb-3">

                    <span class="text-muted">
                        Bunga
                        ({{ number_format($pinjaman->bunga_persen, 2) }}%)
                    </span>

                    <strong>
                        Rp {{ number_format(
                            $pinjaman->jumlah_bunga,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>


                <hr>


                <div class="d-flex justify-content-between mb-3">

                    <span>
                        <strong>Total Pinjaman</strong>
                    </span>

                    <strong class="text-primary fs-5">

                        Rp {{ number_format(
                            $pinjaman->total_pinjaman,
                            0,
                            ',',
                            '.'
                        ) }}

                    </strong>

                </div>


                <div class="d-flex justify-content-between mb-2">

                    <span class="text-muted">
                        Tenor
                    </span>

                    <strong>
                        {{ $pinjaman->tenor }} kali
                    </strong>

                </div>


                <div class="d-flex justify-content-between mb-2">

                    <span class="text-muted">
                        Periode
                    </span>

                    <strong>
                        {{ $pinjaman->periode_hari }} hari
                    </strong>

                </div>


                <div class="d-flex justify-content-between">

                    <span class="text-muted">
                        Angsuran / Periode
                    </span>

                    <strong class="text-success">

                        Rp {{ number_format(
                            $pinjaman->jumlah_angsuran,
                            0,
                            ',',
                            '.'
                        ) }}

                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- RINGKASAN PEMBAYARAN --}}
<div class="row g-3 mb-4">

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">
                    Total Angsuran
                </small>

                <div class="fs-4 fw-bold">

                    {{ $pinjaman->angsuran->count() }}

                    <small class="fs-6 text-muted">
                        kali
                    </small>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">
                    Sudah Dibayar
                </small>

                <div class="fs-4 fw-bold text-success">

                    Rp {{ number_format(
                        $pinjaman->angsuran->sum('jumlah_dibayar'),
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">
                    Sisa Pinjaman
                </small>

                <div class="fs-4 fw-bold text-danger">

                    Rp {{ number_format(
                        max(
                            0,
                            $pinjaman->total_pinjaman -
                            $pinjaman->angsuran->sum('jumlah_dibayar')
                        ),
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>

        </div>

    </div>

</div>


{{-- JADWAL ANGSURAN --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white">

        <div class="d-flex justify-content-between align-items-center">

            <h5 class="mb-0">

                <i class="bi bi-calendar-check me-2"></i>

                Jadwal Angsuran

            </h5>

            <span class="badge bg-primary">

                {{ $pinjaman->tenor }} Kali

            </span>

        </div>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Angsuran Ke
                        </th>

                        <th>
                            Jatuh Tempo
                        </th>

                        <th>
                            Jumlah Angsuran
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

                    </tr>

                </thead>

                <tbody>

                    @forelse($pinjaman->angsuran as $angsuran)

                    @php

                    $sisa =
                    ($angsuran->jumlah_angsuran + $angsuran->denda)
                    - $angsuran->jumlah_dibayar;

                    @endphp

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>

                            <strong>
                                Angsuran
                                {{ $angsuran->angsuran_ke }}
                            </strong>

                        </td>

                        <td>

                            {{ $angsuran->jatuh_tempo
                                    ? $angsuran->jatuh_tempo->format('d-m-Y')
                                    : '-'
                                }}

                        </td>

                        <td>

                            Rp {{ number_format(
                                    $angsuran->jumlah_angsuran,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                        </td>

                        <td class="text-success">

                            Rp {{ number_format(
                                    $angsuran->jumlah_dibayar,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                        </td>

                        <td class="text-danger">

                            Rp {{ number_format(
                                    max(0, $sisa),
                                    0,
                                    ',',
                                    '.'
                                ) }}

                        </td>

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

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7"
                            class="text-center py-4 text-muted">

                            Belum ada jadwal angsuran.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection