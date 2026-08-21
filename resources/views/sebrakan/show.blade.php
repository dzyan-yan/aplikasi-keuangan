@extends('layouts.app')

@section('title', 'Detail Sebrakan')

@section('page-title', 'Detail Sebrakan')

@section('content')

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                <i class="bi bi-receipt text-primary me-2"></i>

                Detail Sebrakan

            </h4>

            <p class="text-muted mb-0">
                Informasi lengkap transaksi sebrakan.
            </p>

        </div>

        <div class="mt-3 mt-md-0">

            <a href="{{ route('sebrakan.index') }}"
                class="btn btn-light border shadow-sm">

                <i class="bi bi-arrow-left me-1"></i>

                Kembali

            </a>

        </div>

    </div>


    <div class="row g-4">

        {{-- Informasi Anggota --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-primary text-white">

                    <strong>

                        <i class="bi bi-person-circle me-2"></i>

                        Informasi Anggota

                    </strong>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <small class="text-muted">
                            Kode Anggota
                        </small>

                        <div class="fw-semibold">
                            {{ $sebrakan->anggota->kode_anggota ?? '-' }}
                        </div>

                    </div>

                    <div class="mb-3">

                        <small class="text-muted">
                            Nama Anggota
                        </small>

                        <div class="fw-semibold">
                            {{ $sebrakan->anggota->nama ?? '-' }}
                        </div>

                    </div>

                    <div>

                        <small class="text-muted">
                            No. HP
                        </small>

                        <div>
                            {{ $sebrakan->anggota->no_hp ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Detail Sebrakan --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <strong>

                        <i class="bi bi-cash-stack text-primary me-2"></i>

                        Detail Transaksi

                    </strong>

                </div>


                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted">
                                Tanggal Sebrakan
                            </small>

                            <div class="fw-semibold">

                                {{ \Carbon\Carbon::parse($sebrakan->tanggal_sebrakan)->format('d F Y') }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Jatuh Tempo
                            </small>

                            <div class="fw-semibold">

                                {{ \Carbon\Carbon::parse($sebrakan->tanggal_jatuh_tempo)->format('d F Y') }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Pokok
                            </small>

                            <div class="fs-5 fw-bold">

                                Rp {{ number_format($sebrakan->pokok, 0, ',', '.') }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Bunga ({{ $sebrakan->bunga_persen }}%)
                            </small>

                            <div class="fs-5 fw-bold text-warning">

                                Rp {{ number_format($sebrakan->bunga, 0, ',', '.') }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Total
                            </small>

                            <div class="fs-4 fw-bold text-primary">

                                Rp {{ number_format($sebrakan->total, 0, ',', '.') }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Jumlah Dibayar
                            </small>

                            <div class="fs-4 fw-bold text-success">

                                Rp {{ number_format($sebrakan->jumlah_bayar ?? 0, 0, ',', '.') }}

                            </div>

                        </div>

                    </div>


                    <hr class="my-4">


                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted d-block">
                                Status
                            </small>

                            @if($sebrakan->status === 'lunas')

                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Lunas
                            </span>

                            @elseif($sebrakan->status === 'terlambat')

                            <span class="badge bg-danger">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                Terlambat
                            </span>

                            @else

                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-clock me-1"></i>
                                Belum Bayar
                            </span>

                            @endif

                        </div>


                        @if($sebrakan->status !== 'lunas')

                        <form action="{{ route('sebrakan.bayar', $sebrakan->id_sebrakan) }}"
                            method="POST">

                            @csrf
                            <a href="{{ route('sebrakan.index') }}"
                                class="btn btn-light border shadow-sm">

                                <i class="bi bi-arrow-left me-1"></i>

                                Kembali

                            </a>


                        </form>

                        @endif

                    </div>


                    @if($sebrakan->tanggal_bayar)

                    <div class="alert alert-success border-0 mt-4 mb-0">

                        <i class="bi bi-check-circle-fill me-2"></i>

                        Sebrakan telah dibayar pada

                        <strong>
                            {{ \Carbon\Carbon::parse($sebrakan->tanggal_bayar)->format('d F Y') }}
                        </strong>

                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>


<style>
    .card {
        border-radius: 12px;
    }

    .card-header {
        border-bottom: 1px solid #f0f0f0;
    }

    .btn {
        border-radius: 8px;
    }
</style>

@endsection