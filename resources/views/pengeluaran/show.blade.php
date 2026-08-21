@extends('layouts.app')

@section('title', 'Detail Pengeluaran')

@section('page-title', 'Detail Pengeluaran')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Detail Pengeluaran
        </h3>

        <p class="text-muted mb-0">
            Informasi lengkap transaksi pengeluaran organisasi.
        </p>

    </div>


    <div class="d-flex gap-2">

        <a
            href="{{ route('pengeluaran.index') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>


    </div>

</div>


{{-- ========================================================= --}}
{{-- INFORMASI PENGELUARAN --}}
{{-- ========================================================= --}}

<div class="row g-4">


    {{-- ===================================================== --}}
    {{-- DETAIL TRANSAKSI --}}
    {{-- ===================================================== --}}

    <div class="col-md-8">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white py-3">

                <strong>

                    <i class="bi bi-wallet2 me-2"></i>

                    Informasi Pengeluaran

                </strong>

            </div>


            <div class="card-body">


                <div class="row g-4">


                    {{-- TANGGAL --}}

                    <div class="col-md-6">

                        <small class="text-muted d-block mb-1">
                            Tanggal
                        </small>

                        <div class="fw-bold">

                            {{ \Carbon\Carbon::parse(
                                $pengeluaran->tanggal
                            )->translatedFormat('d F Y') }}

                        </div>

                    </div>


                    {{-- KATEGORI --}}

                    <div class="col-md-6">

                        <small class="text-muted d-block mb-1">
                            Kategori
                        </small>

                        <div>

                            <span class="badge bg-primary">

                                {{ $pengeluaran->kategori }}

                            </span>

                        </div>

                    </div>


                    {{-- KEPERLUAN --}}

                    <div class="col-md-6">

                        <small class="text-muted d-block mb-1">
                            Keperluan
                        </small>

                        <div class="fw-bold">

                            {{ $pengeluaran->keperluan ?? '-' }}

                        </div>

                    </div>


                    {{-- ADMIN --}}

                    <div class="col-md-6">

                        <small class="text-muted d-block mb-1">
                            Dicatat Oleh
                        </small>

                        <div class="fw-bold">

                            {{ $pengeluaran->admin->nama ?? '-' }}

                        </div>

                    </div>


                    {{-- KETERANGAN --}}

                    <div class="col-12">

                        <small class="text-muted d-block mb-1">
                            Keterangan
                        </small>

                        <div class="border rounded p-3 bg-light">

                            {{ $pengeluaran->keterangan ?? 'Tidak ada keterangan.' }}

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- RINGKASAN --}}
    {{-- ===================================================== --}}

    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white py-3">

                <strong>

                    <i class="bi bi-calculator me-2"></i>

                    Ringkasan

                </strong>

            </div>


            <div class="card-body">


                <div class="mb-4">

                    <small class="text-muted d-block mb-1">
                        Jumlah Pengeluaran
                    </small>

                    <h3 class="text-danger mb-0">

                        Rp {{ number_format(
                            $pengeluaran->jumlah,
                            0,
                            ',',
                            '.'
                        ) }}

                    </h3>

                </div>


                <hr>


                <div class="mb-3">

                    <small class="text-muted d-block mb-1">
                        Kategori
                    </small>

                    <strong>
                        {{ $pengeluaran->kategori }}
                    </strong>

                </div>


                <div class="mb-3">

                    <small class="text-muted d-block mb-1">
                        Tanggal Transaksi
                    </small>

                    <strong>

                        {{ \Carbon\Carbon::parse(
                            $pengeluaran->tanggal
                        )->format('d-m-Y') }}

                    </strong>

                </div>


                <div>

                    <small class="text-muted d-block mb-1">
                        Admin
                    </small>

                    <strong>

                        {{ $pengeluaran->admin->nama ?? '-' }}

                    </strong>

                </div>


            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- INFORMASI SISTEM --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-white py-3">

        <strong>

            <i class="bi bi-info-circle me-2"></i>

            Informasi Sistem

        </strong>

    </div>


    <div class="card-body">

        <div class="row g-4">


            <div class="col-md-4">

                <small class="text-muted d-block mb-1">
                    ID Pengeluaran
                </small>

                <strong>

                    #{{ $pengeluaran->id_pengeluaran }}

                </strong>

            </div>


            <div class="col-md-4">

                <small class="text-muted d-block mb-1">
                    Dibuat
                </small>

                <strong>

                    {{ $pengeluaran->created_at
                        ? $pengeluaran->created_at->format('d-m-Y H:i')
                        : '-'
                    }}

                </strong>

            </div>


            <div class="col-md-4">

                <small class="text-muted d-block mb-1">
                    Terakhir Diubah
                </small>

                <strong>

                    {{ $pengeluaran->updated_at
                        ? $pengeluaran->updated_at->format('d-m-Y H:i')
                        : '-'
                    }}

                </strong>

            </div>


        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- HAPUS --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mt-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <strong class="text-danger">

                    <i class="bi bi-exclamation-triangle me-2"></i>

                    Hapus Transaksi

                </strong>

                <p class="text-muted mb-0 mt-1">

                    Penghapusan transaksi akan menghilangkan
                    data pengeluaran dari laporan keuangan.

                </p>

            </div>


            <form
                action="{{ route(
                    'pengeluaran.destroy',
                    $pengeluaran
                ) }}"
                method="POST"
                onsubmit="return confirm(
                    'Yakin ingin menghapus transaksi pengeluaran ini?'
                );">

                @csrf

                @method('DELETE')
                @if(in_array(session('admin_role'), ['superadmin','admin','bendahara']))

                <button
                    type="submit"
                    class="btn btn-danger">

                    <i class="bi bi-trash me-1"></i>

                    Hapus Pengeluaran

                </button>
                @endif
            </form>

        </div>

    </div>

</div>

@endsection