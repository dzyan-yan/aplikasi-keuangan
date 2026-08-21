@extends('layouts.app')

@section('title', 'Tambah Sebrakan')

@section('page-title', 'Tambah Sebrakan')

@section('content')

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-cash-coin text-primary me-2"></i>
                Tambah Sebrakan
            </h4>

            <p class="text-muted mb-0">
                Tambahkan transaksi sebrakan baru.
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


    {{-- Validation --}}
    @if ($errors->any())

    <div class="alert alert-danger border-0 shadow-sm">

        <strong>
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Data belum dapat disimpan.
        </strong>

        <ul class="mb-0 mt-2">

            @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-header bg-primary text-white py-3">

            <div class="d-flex align-items-center">

                <div class="bg-white bg-opacity-25 rounded-3 p-2 me-3">

                    <i class="bi bi-cash-coin fs-4"></i>

                </div>

                <div>

                    <h5 class="mb-0 fw-semibold">
                        Informasi Sebrakan
                    </h5>

                    <small class="opacity-75">
                        Sistem bunga 5% dan wajib lunas dalam satu selapan.
                    </small>

                </div>

            </div>

        </div>


        <div class="card-body p-4">

            <form action="{{ route('sebrakan.store') }}" method="POST">

                @csrf

                <div class="row g-4">

                    {{-- Anggota --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Anggota
                            <span class="text-danger">*</span>
                        </label>

                        <select name="id_anggota"
                            class="form-select @error('id_anggota') is-invalid @enderror"
                            required>

                            <option value="">
                                -- Pilih Anggota --
                            </option>

                            @foreach($anggotas as $anggota)

                            <option value="{{ $anggota->id_anggota }}"
                                {{ old('id_anggota') == $anggota->id_anggota ? 'selected' : '' }}>

                                {{ $anggota->kode_anggota }}
                                - {{ $anggota->nama }}

                            </option>

                            @endforeach

                        </select>

                        @error('id_anggota')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>


                    {{-- Tanggal --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Tanggal Sebrakan
                            <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                            name="tanggal_sebrakan"
                            class="form-control"
                            value="{{ old('tanggal_sebrakan', date('Y-m-d')) }}"
                            required>

                    </div>


                    {{-- Jatuh Tempo --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Jatuh Tempo
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-calendar-check text-primary"></i>
                            </span>

                            <input
                                type="text"
                                id="jatuh_tempo_display"
                                class="form-control"
                                readonly
                                placeholder="Otomatis 35 hari">
                        </div>

                        <small class="text-muted">
                            Jatuh tempo otomatis 35 hari setelah tanggal sebrakan.
                        </small>

                    </div>


                    {{-- Pokok --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Pokok Sebrakan
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input type="number"
                                id="pokok"
                                name="pokok"
                                class="form-control @error('pokok') is-invalid @enderror"
                                value="{{ old('pokok') }}"
                                min="1"
                                required>

                        </div>

                        @error('pokok')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>


                    {{-- Bunga --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Bunga
                        </label>

                        <div class="input-group">

                            <input type="text"
                                id="bunga"
                                class="form-control"
                                readonly>

                            <span class="input-group-text">
                                5%
                            </span>

                        </div>

                    </div>


                    {{-- Total --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Total yang Harus Dibayar
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-success text-white">
                                Rp
                            </span>

                            <input type="text"
                                id="total"
                                class="form-control fw-bold text-success"
                                readonly>

                        </div>

                    </div>

                </div>


                <hr class="my-4">


                {{-- Info --}}
                <div class="alert alert-info border-0">

                    <i class="bi bi-info-circle-fill me-2"></i>

                    Sebrakan dikenakan bunga
                    <strong>5%</strong>
                    dari pokok dan harus dilunasi dalam satu selapan.

                </div>


                <div class="d-flex justify-content-between">

                    <a href="{{ route('sebrakan.index') }}"
                        class="btn btn-light border">

                        <i class="bi bi-x-lg me-1"></i>
                        Batal

                    </a>

                    <button type="submit"
                        class="btn btn-primary px-4">

                        <i class="bi bi-check-lg me-1"></i>
                        Simpan Sebrakan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const pokok = document.getElementById('pokok');
        const bunga = document.getElementById('bunga');
        const total = document.getElementById('total');

        function hitung() {

            let nilai = parseFloat(pokok.value) || 0;

            let bungaValue = nilai * 0.05;

            let totalValue = nilai + bungaValue;

            bunga.value = new Intl.NumberFormat('id-ID').format(bungaValue);

            total.value = new Intl.NumberFormat('id-ID').format(totalValue);

        }

        pokok.addEventListener('input', hitung);

        hitung();

    });
</script>


<style>
    .card {
        border-radius: 12px;
    }

    .card-header {
        border: none;
    }

    .form-control,
    .form-select,
    .input-group-text {
        min-height: 45px;
    }

    .btn {
        border-radius: 8px;
    }
</style>

@endsection