@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('page-title', 'Tambah Anggota')

@section('content')

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-person-plus-fill text-primary me-2"></i>
                Tambah Anggota
            </h4>

            <p class="text-muted mb-0">
                Tambahkan data anggota baru ke dalam sistem.
            </p>
        </div>

        <div class="mt-3 mt-md-0">
            <a href="{{ route('anggota.index') }}"
                class="btn btn-light border shadow-sm">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>
        </div>

    </div>


    {{-- Error Validation --}}
    @if ($errors->any())

    <div class="alert alert-danger border-0 shadow-sm">

        <div class="d-flex">

            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>

            <div>

                <strong>
                    Data belum dapat disimpan.
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

    @endif


    <div class="card border-0 shadow-sm overflow-hidden">

        {{-- Card Header --}}
        <div class="card-header bg-primary text-white py-3">

            <div class="d-flex align-items-center">

                <div class="bg-white bg-opacity-25 rounded-3 p-2 me-3">

                    <i class="bi bi-person-plus-fill fs-4"></i>

                </div>

                <div>

                    <h5 class="mb-0 fw-semibold">
                        Informasi Anggota
                    </h5>

                    <small class="opacity-75">
                        Lengkapi informasi anggota dengan benar
                    </small>

                </div>

            </div>

        </div>


        {{-- Form --}}
        <div class="card-body p-4">

            <form action="{{ route('anggota.store') }}" method="POST">

                @csrf


                <div class="row g-4">


                    {{-- Nama --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nama Lengkap
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-person text-primary"></i>
                            </span>

                            <input
                                type="text"
                                name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}"
                                placeholder="Masukkan nama lengkap"
                                required>

                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>


                    {{-- NIK --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            NIK
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-person-vcard text-primary"></i>
                            </span>

                            <input
                                type="text"
                                name="nik"
                                class="form-control @error('nik') is-invalid @enderror"
                                value="{{ old('nik') }}"
                                placeholder="Masukkan NIK">

                            @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>


                    {{-- No HP --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            No. HP
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-telephone text-primary"></i>
                            </span>

                            <input
                                type="text"
                                name="no_hp"
                                class="form-control @error('no_hp') is-invalid @enderror"
                                value="{{ old('no_hp') }}"
                                placeholder="Contoh: 081234567890">

                            @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Alamat --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Alamat
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light align-items-start pt-2">
                                <i class="bi bi-geo-alt text-primary"></i>
                            </span>

                            <textarea
                                name="alamat"
                                class="form-control @error('alamat') is-invalid @enderror"
                                rows="3"
                                placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>

                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Tanggal Daftar --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Tanggal Daftar
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-calendar-event text-primary"></i>
                            </span>

                            <input
                                type="date"
                                name="tanggal_daftar"
                                class="form-control @error('tanggal_daftar') is-invalid @enderror"
                                value="{{ old('tanggal_daftar', date('Y-m-d')) }}">

                            @error('tanggal_daftar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Status Anggota
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-toggle-on text-primary"></i>
                            </span>

                            <select
                                name="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>

                                <option value="">
                                    -- Pilih Status --
                                </option>

                                <option value="aktif"
                                    {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="tidak_aktif"
                                    {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>

                            </select>

                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Divider --}}
                <hr class="my-4">


                {{-- Footer Form --}}
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">

                    <div class="text-muted small">

                        <i class="bi bi-info-circle me-1"></i>

                        Field bertanda
                        <span class="text-danger">*</span>
                        wajib diisi.

                    </div>


                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('anggota.index') }}"
                            class="btn btn-light border">

                            <i class="bi bi-x-lg me-1"></i>

                            Batal

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary px-4">

                            <i class="bi bi-check-lg me-1"></i>

                            Simpan Anggota

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- Custom Styling --}}
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

    textarea.form-control {
        min-height: 100px;
    }

    .input-group-text {
        min-width: 46px;
        justify-content: center;
        border-color: #dee2e6;
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .12);
    }

    .btn {
        border-radius: 8px;
    }

    .alert {
        border-radius: 10px;
    }
</style>

@endsection