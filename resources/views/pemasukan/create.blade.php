@extends('layouts.app')

@section('title', 'Tambah Pemasukan')

@section('page-title', 'Tambah Pemasukan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Tambah Pemasukan
        </h3>

        <p class="text-muted mb-0">
            Tambahkan transaksi pemasukan organisasi.
        </p>

    </div>


    <a
        href="{{ route('pemasukan.index') }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>


@if($errors->any())

<div class="alert alert-danger">

    <div class="fw-bold mb-2">

        <i class="bi bi-exclamation-triangle me-1"></i>

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


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <strong>

            <i class="bi bi-cash-stack me-2"></i>

            Form Pemasukan

        </strong>

    </div>


    <div class="card-body">

        <form
            action="{{ route('pemasukan.store') }}"
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

                        <option
                            value="Angsuran"
                            {{ old('kategori') === 'Angsuran'
                                ? 'selected'
                                : '' }}>

                            Pembayaran Angsuran

                        </option>

                        <option
                            value="Sebrakan"
                            {{ old('kategori') === 'Sebrakan'
                                ? 'selected'
                                : '' }}>

                            Sebrakan

                        </option>

                        <option
                            value="Sewa"
                            {{ old('kategori') === 'Sewa'
                                ? 'selected'
                                : '' }}>

                            Sewa

                        </option>

                        <option
                            value="Iuran Anggota"
                            {{ old('kategori') === 'Iuran Anggota'
                                ? 'selected'
                                : '' }}>

                            Iuran Anggota

                        </option>

                        <option
                            value="Donasi"
                            {{ old('kategori') === 'Donasi'
                                ? 'selected'
                                : '' }}>

                            Donasi

                        </option>

                        <option
                            value="Penjualan"
                            {{ old('kategori') === 'Penjualan'
                                ? 'selected'
                                : '' }}>

                            Penjualan

                        </option>

                        <option
                            value="Jasa"
                            {{ old('kategori') === 'Jasa'
                                ? 'selected'
                                : '' }}>

                            Jasa

                        </option>

                        <option
                            value="Bunga"
                            {{ old('kategori') === 'Bunga'
                                ? 'selected'
                                : '' }}>

                            Bunga

                        </option>

                        <option
                            value="Lainnya"
                            {{ old('kategori') === 'Lainnya'
                                ? 'selected'
                                : '' }}>

                            Lainnya

                        </option>

                    </select>

                    @error('kategori')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- SUMBER --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Sumber Pemasukan

                    </label>

                    <input
                        type="text"
                        name="sumber"
                        class="form-control @error('sumber') is-invalid @enderror"
                        value="{{ old('sumber') }}"
                        placeholder="Contoh: Sutiman, Penyewa Gedung, Donatur">

                    @error('sumber')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                    <div class="form-text">

                        Nama orang, anggota, instansi, atau sumber pemasukan.

                    </div>

                </div>


                {{-- JUMLAH --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Jumlah Pemasukan

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
                            min="0"
                            step="0.01"
                            placeholder="Masukkan jumlah"
                            required>

                    </div>

                    @error('jumlah')

                    <div class="text-danger small mt-1">
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
                        placeholder="Masukkan keterangan transaksi">{{ old('keterangan') }}</textarea>

                    @error('keterangan')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


            </div>


            <hr class="my-4">


            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('pemasukan.index') }}"
                    class="btn btn-secondary">

                    <i class="bi bi-x-lg me-1"></i>

                    Batal

                </a>


                <button
                    type="submit"
                    class="btn btn-success">

                    <i class="bi bi-save me-1"></i>

                    Simpan Pemasukan

                </button>

            </div>


        </form>

    </div>

</div>

@endsection