@extends('layouts.app')

@section('title', 'Edit Pemasukan')

@section('page-title', 'Edit Pemasukan')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Edit Pemasukan
        </h3>

        <p class="text-muted mb-0">
            Ubah data transaksi pemasukan organisasi.
        </p>

    </div>

    <a
        href="{{ route('pemasukan.show', $pemasukan) }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>


{{-- ========================================================= --}}
{{-- FORM --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <strong>

            <i class="bi bi-pencil-square me-2"></i>

            Form Edit Pemasukan

        </strong>

    </div>


    <div class="card-body">


        {{-- ================================================= --}}
        {{-- ERROR VALIDASI --}}
        {{-- ================================================= --}}

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


        {{-- ================================================= --}}
        {{-- INFORMASI TRANSAKSI --}}
        {{-- ================================================= --}}

        <div class="alert alert-light border mb-4">

            <div class="row g-3">

                <div class="col-md-4">

                    <small class="text-muted">
                        ID Pemasukan
                    </small>

                    <div class="fw-bold">
                        #{{ $pemasukan->id_pemasukan }}
                    </div>

                </div>


                <div class="col-md-4">

                    <small class="text-muted">
                        Dicatat Oleh
                    </small>

                    <div class="fw-bold">

                        {{ $pemasukan->admin->nama ?? '-' }}

                    </div>

                </div>


                <div class="col-md-4">

                    <small class="text-muted">
                        Referensi
                    </small>

                    <div class="fw-bold">

                        @if($pemasukan->referensi_type)

                        {{ ucfirst($pemasukan->referensi_type) }}

                        @if($pemasukan->referensi_id)
                        #{{ $pemasukan->referensi_id }}
                        @endif

                        @else

                        Manual

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- FORM --}}
        {{-- ================================================= --}}

        <form
            action="{{ route(
                'pemasukan.update',
                $pemasukan
            ) }}"
            method="POST">

            @csrf

            @method('PUT')


            <div class="row">


                {{-- ================================================= --}}
                {{-- TANGGAL --}}
                {{-- ================================================= --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Tanggal

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old(
                            'tanggal',
                            $pemasukan->tanggal instanceof \Carbon\Carbon
                                ? $pemasukan->tanggal->format('Y-m-d')
                                : $pemasukan->tanggal
                        ) }}"
                        required>

                    @error('tanggal')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>

                {{-- ================================================= --}}
                {{-- KATEGORI --}}
                {{-- ================================================= --}}

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
                            {{ old(
                'kategori',
                $pemasukan->kategori
            ) === 'Angsuran'
                ? 'selected'
                : '' }}>

                            Pembayaran Angsuran

                        </option>


                        <option
                            value="Sebrakan"
                            {{ old(
                'kategori',
                $pemasukan->kategori
            ) === 'Sebrakan'
                ? 'selected'
                : '' }}>

                            Sebrakan

                        </option>


                        <option
                            value="Sewa"
                            {{ old(
                'kategori',
                $pemasukan->kategori
            ) === 'Sewa'
                ? 'selected'
                : '' }}>

                            Sewa

                        </option>


                        <option
                            value="Iuran Anggota"
                            {{ old(
                'kategori',
                $pemasukan->kategori
            ) === 'Iuran Anggota'
                ? 'selected'
                : '' }}>

                            Iuran Anggota

                        </option>


                        <option
                            value="Donasi"
                            {{ old(
                'kategori',
                $pemasukan->kategori
            ) === 'Donasi'
                ? 'selected'
                : '' }}>

                            Donasi

                        </option>


                        <option
                            value="Penjualan"
                            {{ old(
                'kategori',
                $pemasukan->kategori
            ) === 'Penjualan'
                ? 'selected'
                : '' }}>

                            Penjualan

                        </option>


                        <option
                            value="Jasa"
                            {{ old(
                'kategori',
                $pemasukan->kategori
            ) === 'Jasa'
                ? 'selected'
                : '' }}>

                            Jasa

                        </option>


                        <option
                            value="Bunga"
                            {{ old(
                'kategori',
                $pemasukan->kategori
            ) === 'Bunga'
                ? 'selected'
                : '' }}>

                            Bunga

                        </option>


                        <option
                            value="Lainnya"
                            {{ old(
                'kategori',
                $pemasukan->kategori
            ) === 'Lainnya'
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


                {{-- ================================================= --}}
                {{-- SUMBER --}}
                {{-- ================================================= --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Sumber Pemasukan

                    </label>

                    <input
                        type="text"
                        name="sumber"
                        class="form-control @error('sumber') is-invalid @enderror"
                        value="{{ old(
                            'sumber',
                            $pemasukan->sumber
                        ) }}"
                        placeholder="Contoh: Anggota, Penyewa, Donatur">

                    @error('sumber')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- JUMLAH --}}
                {{-- ================================================= --}}

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
                            value="{{ old(
                                'jumlah',
                                $pemasukan->jumlah
                            ) }}"
                            min="1"
                            step="0.01"
                            required>

                    </div>


                    @error('jumlah')

                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- KETERANGAN --}}
                {{-- ================================================= --}}

                <div class="col-12 mb-3">

                    <label class="form-label">

                        Keterangan

                    </label>

                    <textarea
                        name="keterangan"
                        rows="4"
                        class="form-control @error('keterangan') is-invalid @enderror"
                        placeholder="Tambahkan keterangan jika diperlukan">{{ old(
                            'keterangan',
                            $pemasukan->keterangan
                        ) }}</textarea>

                    @error('keterangan')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror

                </div>


            </div>


            {{-- ================================================= --}}
            {{-- PERINGATAN PEMASUKAN OTOMATIS --}}
            {{-- ================================================= --}}

            @if($pemasukan->referensi_type === 'pembayaran')

            <div class="alert alert-warning">

                <i class="bi bi-exclamation-triangle me-2"></i>

                <strong>Perhatian:</strong>

                Pemasukan ini dibuat otomatis dari pembayaran
                angsuran.

                Sebaiknya perubahan transaksi pembayaran dilakukan
                melalui modul <strong>Pembayaran Angsuran</strong> agar
                data angsuran dan pemasukan tetap sinkron.

            </div>

            @endif


            <hr class="my-4">


            {{-- ================================================= --}}
            {{-- TOMBOL --}}
            {{-- ================================================= --}}

            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route(
                        'pemasukan.show',
                        $pemasukan
                    ) }}"
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


        </form>

    </div>

</div>

@endsection