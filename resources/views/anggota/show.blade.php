@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('page-title', 'Detail Anggota')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">
            Detail Anggota
        </h3>

        <p class="text-muted mb-0">
            Informasi lengkap anggota dan riwayat pinjaman.
        </p>
    </div>

    <div class="d-flex gap-2">

        <a
            href="{{ route('anggota.index') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>

    </div>

</div>


<div class="row g-4">

    {{-- INFORMASI ANGGOTA --}}

    <div class="col-lg-5">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <strong>

                        <i class="bi bi-person-vcard me-2"></i>

                        Informasi Anggota

                    </strong>

                    @if($anggota->status === 'aktif')

                    <span class="badge bg-success">
                        Aktif
                    </span>

                    @else

                    <span class="badge bg-secondary">
                        Tidak Aktif
                    </span>

                    @endif

                </div>

            </div>


            <div class="card-body">

                <div class="text-center mb-4">

                    <div
                        class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                        style="width:80px;height:80px;font-size:32px;">

                        <i class="bi bi-person"></i>

                    </div>

                    <h4 class="mt-3 mb-1">

                        {{ $anggota->nama }}

                    </h4>

                    <span class="badge bg-secondary">

                        {{ $anggota->kode_anggota }}

                    </span>

                </div>


                <hr>


                <div class="row mb-3">

                    <div class="col-5 text-muted">
                        NIK
                    </div>

                    <div class="col-7 fw-semibold">
                        {{ $anggota->nik ?? '-' }}
                    </div>

                </div>


                <div class="row mb-3">

                    <div class="col-5 text-muted">
                        No. HP
                    </div>

                    <div class="col-7 fw-semibold">
                        {{ $anggota->no_hp ?? '-' }}
                    </div>

                </div>


                <div class="row mb-3">

                    <div class="col-5 text-muted">
                        Tanggal Daftar
                    </div>

                    <div class="col-7 fw-semibold">

                        {{ $anggota->tanggal_daftar
                            ? $anggota->tanggal_daftar->format('d-m-Y')
                            : '-'
                        }}

                    </div>

                </div>


                <div class="row mb-3">

                    <div class="col-5 text-muted">
                        Alamat
                    </div>

                    <div class="col-7 fw-semibold">

                        {{ $anggota->alamat ?? '-' }}

                    </div>

                </div>


                <div class="row">

                    <div class="col-5 text-muted">
                        Status
                    </div>

                    <div class="col-7">

                        @if($anggota->status === 'aktif')

                        <span class="badge bg-success">
                            Aktif
                        </span>

                        @else

                        <span class="badge bg-secondary">
                            Tidak Aktif
                        </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- RINGKASAN PINJAMAN --}}

    <div class="col-lg-7">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <strong>

                    <i class="bi bi-cash-stack me-2"></i>

                    Ringkasan Pinjaman

                </strong>

            </div>


            <div class="card-body">

                @php

                $jumlahPinjaman = $anggota->pinjaman->count();

                @endphp


                <div class="row g-3">

                    <div class="col-md-4">

                        <div class="border rounded p-3 h-100">

                            <div class="text-muted small">
                                Total Pinjaman
                            </div>

                            <div class="fs-4 fw-bold">
                                {{ $jumlahPinjaman }}
                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="border rounded p-3 h-100">

                            <div class="text-muted small">
                                Pinjaman Aktif
                            </div>

                            <div class="fs-4 fw-bold text-primary">

                                {{ $anggota->pinjaman
                                    ->where('status', 'aktif')
                                    ->count()
                                }}

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="border rounded p-3 h-100">

                            <div class="text-muted small">
                                Pinjaman Lunas
                            </div>

                            <div class="fs-4 fw-bold text-success">

                                {{ $anggota->pinjaman
                                    ->where('status', 'lunas')
                                    ->count()
                                }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- RIWAYAT PINJAMAN --}}

        <div class="card border-0 shadow-sm mt-4">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <strong>

                        <i class="bi bi-clock-history me-2"></i>

                        Riwayat Pinjaman

                    </strong>




                </div>

            </div>


            <div class="card-body p-0">

                @if($anggota->pinjaman->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>
                                    No
                                </th>

                                <th>
                                    Nomor Pinjaman
                                </th>

                                <th>
                                    Jumlah
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Tanggal
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach(
                            $anggota->pinjaman
                            as $index => $pinjaman
                            )

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <b>

                                        {{ $pinjaman->no_pinjaman
                                                ?? '-'
                                            }}
                                    </b>
                                </td>

                                <td>

                                    Rp
                                    {{ number_format(
                                                $pinjaman->jumlah_pinjaman
                                                ?? 0,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                </td>

                                <td>

                                    @if(
                                    ($pinjaman->status ?? '')
                                    === 'aktif'
                                    )

                                    <span
                                        class="badge bg-primary">

                                        Aktif

                                    </span>

                                    @elseif(
                                    ($pinjaman->status ?? '')
                                    === 'lunas'
                                    )

                                    <span
                                        class="badge bg-success">

                                        Lunas

                                    </span>

                                    @else

                                    <span
                                        class="badge bg-secondary">

                                        {{ $pinjaman->status
                                                        ?? '-'
                                                    }}

                                    </span>

                                    @endif

                                </td>

                                <td>

                                    {{ isset(
                                                $pinjaman->tanggal_pinjaman
                                            )
                                                ? \Carbon\Carbon::parse(
                                                    $pinjaman->tanggal_pinjaman
                                                )->format('d-m-Y')
                                                : '-'
                                            }}

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                @else

                <div class="text-center py-5">

                    <div class="mb-3">

                        <i
                            class="bi bi-wallet2"
                            style="font-size:45px;">
                        </i>

                    </div>

                    <h5>
                        Belum Ada Pinjaman
                    </h5>

                    <p class="text-muted mb-0">

                        Anggota ini belum memiliki
                        riwayat pinjaman.

                    </p>

                </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection