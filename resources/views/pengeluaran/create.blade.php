@extends('layouts.app')

@section('title', 'Tambah Pengeluaran')

@section('page-title', 'Tambah Pengeluaran')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">
            Tambah Pengeluaran
        </h3>

        <p class="text-muted mb-0">
            Catat pengeluaran organisasi.
        </p>
    </div>

    <a href="{{ route('pengeluaran.index') }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left me-1"></i>
        Kembali

    </a>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <strong>
            <i class="bi bi-wallet2 me-2"></i>
            Form Pengeluaran
        </strong>

    </div>


    <div class="card-body">

        {{-- ERROR VALIDASI --}}

        @if($errors->any())

        <div class="alert alert-danger">

            <div class="fw-bold mb-2">
                Terdapat kesalahan:
            </div>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

                @endforeach

            </ul>

        </div>

        @endif


        <form
            action="{{ route('pengeluaran.store') }}"
            method="POST">

            @csrf


            <div class="row">


                {{-- TANGGAL --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Tanggal

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal', date('Y-m-d')) }}"
                        required>

                    @error('tanggal')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- KATEGORI --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Kategori

                        <span class="text-danger">*</span>

                    </label>

                    <select
                        name="kategori"
                        class="form-select @error('kategori') is-invalid @enderror"
                        required>

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        <option value="Kegiatan"
                            {{ old('kategori') == 'Kegiatan' ? 'selected' : '' }}>
                            Kegiatan
                        </option>

                        <option value="Operasional"
                            {{ old('kategori') == 'Operasional' ? 'selected' : '' }}>
                            Operasional
                        </option>

                        <option value="ATK"
                            {{ old('kategori') == 'ATK' ? 'selected' : '' }}>
                            ATK
                        </option>

                        <option value="Listrik"
                            {{ old('kategori') == 'Listrik' ? 'selected' : '' }}>
                            Listrik
                        </option>

                        <option value="Air"
                            {{ old('kategori') == 'Air' ? 'selected' : '' }}>
                            Air
                        </option>

                        <option value="Internet"
                            {{ old('kategori') == 'Internet' ? 'selected' : '' }}>
                            Internet
                        </option>

                        <option value="Transportasi"
                            {{ old('kategori') == 'Transportasi' ? 'selected' : '' }}>
                            Transportasi
                        </option>

                        <option value="Honor"
                            {{ old('kategori') == 'Honor' ? 'selected' : '' }}>
                            Honor
                        </option>

                        <option value="Konsumsi"
                            {{ old('kategori') == 'Konsumsi' ? 'selected' : '' }}>
                            Konsumsi
                        </option>

                        <option value="Sosial"
                            {{ old('kategori') == 'Sosial' ? 'selected' : '' }}>
                            Sosial
                        </option>

                        <option value="Lainnya"
                            {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>
                            Lainnya
                        </option>

                    </select>

                    @error('kategori')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- KEPERLUAN --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Keperluan

                    </label>

                    <input
                        type="text"
                        name="keperluan"
                        class="form-control @error('keperluan') is-invalid @enderror"
                        value="{{ old('keperluan') }}"
                        placeholder="Contoh: Turnamen Volly">

                    @error('keperluan')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- JUMLAH --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Jumlah Pengeluaran

                        <span class="text-danger">*</span>

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            Rp
                        </span>

                        <input
                            type="number"
                            name="jumlah"
                            class="form-control @error('jumlah') is-invalid @enderror"
                            value="{{ old('jumlah') }}"
                            min="1"
                            step="0.01"
                            placeholder="0"
                            required>

                    </div>

                    @error('jumlah')

                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- KETERANGAN --}}

                <div class="col-12 mb-3">

                    <label class="form-label">

                        Keterangan

                    </label>

                    <textarea
                        name="keterangan"
                        rows="4"
                        class="form-control @error('keterangan') is-invalid @enderror"
                        placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan') }}</textarea>

                    @error('keterangan')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


            </div>


            <hr class="my-4">


            {{-- TOMBOL --}}

            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('pengeluaran.index') }}"
                    class="btn btn-secondary">

                    <i class="bi bi-x-lg me-1"></i>
                    Batal

                </a>


                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-save me-1"></i>
                    Simpan Pengeluaran

                </button>

            </div>


        </form>

    </div>

</div>

@endsection