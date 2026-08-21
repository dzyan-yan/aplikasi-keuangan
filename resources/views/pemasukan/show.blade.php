@extends('layouts.app')

@section('title', 'Detail Pemasukan')

@section('page-title', 'Detail Pemasukan')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Detail Pemasukan
        </h3>

        <p class="text-muted mb-0">
            Informasi lengkap transaksi pemasukan organisasi.
        </p>

    </div>


    <div class="d-flex gap-2">

        <a
            href="{{ route('pemasukan.index') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>

    </div>

</div>


{{-- ========================================================= --}}
{{-- ALERT --}}
{{-- ========================================================= --}}

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    <i class="bi bi-check-circle me-2"></i>

    {{ session('success') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

@endif


{{-- ========================================================= --}}
{{-- INFORMASI UTAMA --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <strong>

                <i class="bi bi-cash-stack me-2"></i>

                Informasi Transaksi

            </strong>


        </div>

    </div>


    <div class="card-body">

        <div class="row g-4">


            {{-- ID --}}

            <div class="col-md-4">

                <small class="text-muted">
                    ID Transaksi
                </small>

                <div class="fw-bold">

                    #{{ $pemasukan->id_pemasukan }}

                </div>

            </div>


            {{-- TANGGAL --}}

            <div class="col-md-4">

                <small class="text-muted">
                    Tanggal
                </small>

                <div class="fw-bold">

                    {{ \Carbon\Carbon::parse(
                        $pemasukan->tanggal
                    )->format('d-m-Y') }}

                </div>

            </div>


            {{-- KATEGORI --}}

            <div class="col-md-4">

                <small class="text-muted">
                    Kategori
                </small>

                <div>

                    <span class="badge bg-primary">

                        {{ $pemasukan->kategori }}

                    </span>

                </div>

            </div>


            {{-- SUMBER --}}

            <div class="col-md-6">

                <small class="text-muted">
                    Sumber Pemasukan
                </small>

                <div class="fw-bold">

                    {{ $pemasukan->sumber ?? '-' }}

                </div>

            </div>


            {{-- JUMLAH --}}

            <div class="col-md-6">

                <small class="text-muted">
                    Jumlah Pemasukan
                </small>

                <div class="fw-bold text-success fs-4">

                    Rp {{ number_format(
                        $pemasukan->jumlah,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>


            {{-- KETERANGAN --}}

            <div class="col-12">

                <small class="text-muted">
                    Keterangan
                </small>

                <div class="mt-1">

                    {{ $pemasukan->keterangan ?? '-' }}

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- REFERENSI TRANSAKSI --}}
{{-- ========================================================= --}}

@if($pemasukan->referensi_type)

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white py-3">

        <strong>

            <i class="bi bi-link-45deg me-2"></i>

            Referensi Transaksi

        </strong>

    </div>


    <div class="card-body">

        @if($pemasukan->referensi_type === 'pembayaran')

        @php

        $pembayaran = null;

        if ($pemasukan->referensi_id) {

        $pembayaran =
        \App\Models\Pembayaran::with([
        'angsuran.pinjaman.anggota',
        'admin'
        ])->find(
        $pemasukan->referensi_id
        );

        }

        @endphp


        @if($pembayaran)

        <div class="row g-4">


            {{-- NO PINJAMAN --}}

            <div class="col-md-4">

                <small class="text-muted">
                    No. Pinjaman
                </small>

                <div class="fw-bold">

                    {{ $pembayaran
                                ->angsuran
                                ->pinjaman
                                ->no_pinjaman }}

                </div>

            </div>


            {{-- ANGGOTA --}}

            <div class="col-md-4">

                <small class="text-muted">
                    Anggota
                </small>

                <div class="fw-bold">

                    {{ $pembayaran
                                ->angsuran
                                ->pinjaman
                                ->anggota
                                ->nama }}

                </div>

            </div>


            {{-- ANGSURAN --}}

            <div class="col-md-4">

                <small class="text-muted">
                    Angsuran Ke
                </small>

                <div class="fw-bold">

                    Ke-

                    {{ $pembayaran
                                ->angsuran
                                ->angsuran_ke }}

                </div>

            </div>


            {{-- TANGGAL BAYAR --}}

            <div class="col-md-4">

                <small class="text-muted">
                    Tanggal Bayar
                </small>

                <div class="fw-bold">

                    {{ \Carbon\Carbon::parse(
                                $pembayaran->tanggal_bayar
                            )->format('d-m-Y') }}

                </div>

            </div>


            {{-- JUMLAH BAYAR --}}

            <div class="col-md-4">

                <small class="text-muted">
                    Jumlah Pembayaran
                </small>

                <div class="fw-bold text-success">

                    Rp {{ number_format(
                                $pembayaran->jumlah_bayar,
                                0,
                                ',',
                                '.'
                            ) }}

                </div>

            </div>


            {{-- ADMIN --}}

            <div class="col-md-4">

                <small class="text-muted">
                    Admin Pembayaran
                </small>

                <div class="fw-bold">

                    {{ $pembayaran->admin->nama ?? '-' }}

                </div>

            </div>


        </div>


        <hr>


        @else

        <div class="alert alert-warning mb-0">

            <i class="bi bi-exclamation-triangle me-2"></i>

            Data pembayaran yang menjadi referensi
            transaksi ini tidak ditemukan.

        </div>

        @endif


        @else

        <div class="row">

            <div class="col-md-6">

                <small class="text-muted">
                    Jenis Referensi
                </small>

                <div class="fw-bold">

                    {{ ucfirst(
                            $pemasukan->referensi_type
                        ) }}

                </div>

            </div>


            <div class="col-md-6">

                <small class="text-muted">
                    ID Referensi
                </small>

                <div class="fw-bold">

                    #{{ $pemasukan->referensi_id ?? '-' }}

                </div>

            </div>

        </div>

        @endif

    </div>

</div>

@endif


{{-- ========================================================= --}}
{{-- INFORMASI ADMIN --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white py-3">

        <strong>

            <i class="bi bi-person-badge me-2"></i>

            Informasi Pencatatan

        </strong>

    </div>


    <div class="card-body">

        <div class="row g-4">


            {{-- ADMIN --}}

            <div class="col-md-4">

                <small class="text-muted">
                    Dicatat Oleh
                </small>

                <div class="fw-bold">

                    {{ $pemasukan->admin->nama ?? '-' }}

                </div>

            </div>


            {{-- CREATED --}}

            <div class="col-md-4">

                <small class="text-muted">
                    Dibuat
                </small>

                <div>

                    {{ $pemasukan->created_at
                        ? $pemasukan->created_at->format(
                            'd-m-Y H:i'
                        )
                        : '-'
                    }}

                </div>

            </div>


            {{-- UPDATED --}}

            <div class="col-md-4">

                <small class="text-muted">
                    Terakhir Diubah
                </small>

                <div>

                    {{ $pemasukan->updated_at
                        ? $pemasukan->updated_at->format(
                            'd-m-Y H:i'
                        )
                        : '-'
                    }}

                </div>

            </div>


        </div>

    </div>

</div>



@endsection