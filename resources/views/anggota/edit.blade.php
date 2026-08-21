@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('page-title', 'Edit Anggota')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">Edit Anggota</h3>

        <p class="text-muted mb-0">
            Perbarui data anggota.
        </p>
    </div>

    <a
        href="{{ route('anggota.index') }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left me-1"></i>
        Kembali

    </a>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <strong>
                <i class="bi bi-pencil-square me-2"></i>
                Form Edit Anggota
            </strong>

            <span class="badge bg-secondary">
                {{ $anggota->kode_anggota }}
            </span>

        </div>

    </div>


    <div class="card-body">

        @if($errors->any())

        <div class="alert alert-danger">

            <strong>Terdapat kesalahan:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif


        <form
            action="{{ route('anggota.update', [
                'anggota' => $anggota->id_anggota
            ]) }}"
            method="POST">

            @csrf

            @method('PUT')


            <div class="row">

                {{-- KODE --}}

                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Kode Anggota
                    </label>
                    <div class="input-group">

                        <span class="input-group-text bg-light">
                            <i class="bi bi-upc-scan text-primary"></i>
                        </span>

                        <input
                            type="text"
                            class="form-control bg-light"
                            value="{{ $anggota->kode_anggota }}"
                            readonly>

                    </div>

                    <div class="form-text">
                        Kode anggota dibuat otomatis oleh sistem dan tidak dapat diubah.
                    </div>

                </div>


                {{-- NAMA --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Nama Anggota
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $anggota->nama) }}"
                        required>

                    @error('nama')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- NIK --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        NIK
                    </label>

                    <input
                        type="text"
                        name="nik"
                        class="form-control @error('nik') is-invalid @enderror"
                        value="{{ old('nik', $anggota->nik) }}">

                    @error('nik')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- NO HP --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        No. HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        class="form-control @error('no_hp') is-invalid @enderror"
                        value="{{ old('no_hp', $anggota->no_hp) }}">

                    @error('no_hp')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- TANGGAL DAFTAR --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Tanggal Daftar
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="tanggal_daftar"
                        class="form-control @error('tanggal_daftar') is-invalid @enderror"
                        value="{{ old(
                            'tanggal_daftar',
                            $anggota->tanggal_daftar
                                ? $anggota->tanggal_daftar->format('Y-m-d')
                                : ''
                        ) }}"
                        required>

                    @error('tanggal_daftar')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- STATUS --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required>

                        <option value="aktif"
                            {{ old('status', $anggota->status) === 'aktif'
            ? 'selected'
            : '' }}>

                            Aktif

                        </option>

                        <option value="nonaktif"
                            {{ old('status', $anggota->status) === 'nonaktif'
            ? 'selected'
            : '' }}>

                            Tidak Aktif

                        </option>

                    </select>

                    @error('status')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- ALAMAT --}}

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        rows="3"
                        class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $anggota->alamat) }}</textarea>

                    @error('alamat')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>

            </div>


            <hr class="my-4">


            <div class="d-flex justify-content-between">

                <a
                    href="{{ route('anggota.show', [
                        'anggota' => $anggota->id_anggota
                    ]) }}"
                    class="btn btn-outline-info">

                    <i class="bi bi-eye me-1"></i>
                    Lihat Detail

                </a>


                <div class="d-flex gap-2">

                    <a
                        href="{{ route('anggota.index') }}"
                        class="btn btn-secondary">

                        <i class="bi bi-x-lg me-1"></i>
                        Batal

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection