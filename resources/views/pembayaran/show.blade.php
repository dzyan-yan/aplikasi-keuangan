@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('page-title', 'Detail Pembayaran')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Detail Pembayaran
        </h3>

        <p class="text-muted mb-0">
            Informasi lengkap transaksi pembayaran angsuran.
        </p>

    </div>
    <div class="d-flex gap-2">

        <a
            href="{{ route('angsuran.anggota', [
            $pembayaran->angsuran->pinjaman->id_anggota
        ]) }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>


        <a
            href="{{ route(
            'pembayaran.kuitansi',
            $pembayaran
        ) }}"
            target="_blank"
            class="btn btn-danger">

            <i class="bi bi-file-earmark-pdf me-1"></i>

            Cetak Kuitansi

        </a>

    </div>

</div>


<div class="row">


    {{-- INFORMASI PEMBAYARAN --}}

    <div class="col-md-8 mb-4">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <strong>

                    <i class="bi bi-receipt me-2"></i>

                    Informasi Pembayaran

                </strong>

            </div>


            <div class="card-body">


                <div class="row mb-3">

                    <div class="col-md-6">

                        <small class="text-muted">
                            ID Pembayaran
                        </small>

                        <div class="fw-bold">

                            #{{ $pembayaran->id_pembayaran }}

                        </div>

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted">
                            Tanggal Pembayaran
                        </small>

                        <div class="fw-bold">

                            {{ \Carbon\Carbon::parse(
                                $pembayaran->tanggal_bayar
                            )->format('d-m-Y') }}

                        </div>

                    </div>

                </div>


                <div class="row mb-3">

                    <div class="col-md-6">

                        <small class="text-muted">
                            Nama Anggota
                        </small>

                        <div class="fw-bold">

                            {{ $pembayaran->angsuran
                                ->pinjaman
                                ->anggota
                                ->nama }}

                        </div>

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted">
                            Kode Anggota
                        </small>

                        <div>

                            {{ $pembayaran->angsuran
                                ->pinjaman
                                ->anggota
                                ->kode_anggota }}

                        </div>

                    </div>

                </div>


                <div class="row mb-3">

                    <div class="col-md-6">

                        <small class="text-muted">
                            No. Pinjaman
                        </small>

                        <div class="fw-bold">

                            {{ $pembayaran->angsuran
                                ->pinjaman
                                ->no_pinjaman }}

                        </div>

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted">
                            Angsuran Ke
                        </small>

                        <div class="fw-bold">

                            {{ $pembayaran->angsuran->angsuran_ke }}

                            /

                            {{ $pembayaran->angsuran
                                ->pinjaman
                                ->tenor }}

                        </div>

                    </div>

                </div>


                <hr>


                {{-- NILAI TRANSAKSI --}}

                <div class="row text-center">


                    <div class="col-md-4 mb-3">

                        <small class="text-muted">
                            Tagihan Angsuran
                        </small>

                        <div class="fs-5 fw-bold">

                            Rp
                            {{ number_format(
                                $pembayaran->angsuran
                                    ->jumlah_angsuran,
                                0,
                                ',',
                                '.'
                            ) }}

                        </div>

                    </div>


                    <div class="col-md-4 mb-3">

                        <small class="text-muted">
                            Jumlah Bayar
                        </small>

                        <div class="fs-5 fw-bold text-success">

                            Rp
                            {{ number_format(
                                $pembayaran->jumlah_bayar,
                                0,
                                ',',
                                '.'
                            ) }}

                        </div>

                    </div>


                    <div class="col-md-4 mb-3">

                        <small class="text-muted">
                            Denda
                        </small>

                        <div class="fs-5 fw-bold text-danger">

                            Rp
                            {{ number_format(
                                $pembayaran->denda,
                                0,
                                ',',
                                '.'
                            ) }}

                        </div>

                    </div>

                </div>


                <hr>


                <div class="mb-0">

                    <small class="text-muted">
                        Keterangan
                    </small>

                    <div class="mt-1">

                        {{ $pembayaran->keterangan ?: '-' }}

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ADMIN --}}

    <div class="col-md-4 mb-4">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <strong>

                    <i class="bi bi-person-badge me-2"></i>

                    Petugas

                </strong>

            </div>


            <div class="card-body text-center">

                <div
                    class="rounded-circle bg-primary text-white
                           d-inline-flex align-items-center
                           justify-content-center mb-3"
                    style="width:70px;height:70px;">

                    <i class="bi bi-person fs-3"></i>

                </div>


                <h5 class="mb-1">

                    {{ $pembayaran->admin->nama ?? '-' }}

                </h5>


                <small class="text-muted">

                    Admin

                </small>

            </div>

        </div>


        {{-- STATUS ANGSURAN --}}

        <div class="card border-0 shadow-sm mt-3">

            <div class="card-body">

                <div class="text-muted small mb-1">
                    Status Angsuran
                </div>


                @if(
                $pembayaran->angsuran->status === 'lunas'
                )

                <span class="badge bg-success">

                    <i class="bi bi-check-circle me-1"></i>

                    Lunas

                </span>

                @elseif(
                $pembayaran->angsuran->status === 'sebagian'
                )

                <span class="badge bg-warning text-dark">

                    <i class="bi bi-hourglass-split me-1"></i>

                    Sebagian

                </span>

                @else

                <span class="badge bg-secondary">

                    Belum Bayar

                </span>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection