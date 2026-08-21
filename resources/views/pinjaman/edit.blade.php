@extends('layouts.app')

@section('title', 'Edit Pinjaman')

@section('page-title', 'Edit Pinjaman')

@section('content')

<div class="container-fluid px-0">

    ```
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-pencil-square text-primary me-2"></i>
                Edit Pinjaman
            </h4>

            <p class="text-muted mb-0">
                Perbarui data pinjaman anggota.
            </p>
        </div>

        <div class="mt-3 mt-md-0">

            <a href="{{ route('pinjaman.show', $pinjaman) }}"
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
                    Data belum dapat diperbarui.
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


    {{-- Alert --}}
    @if(session('error'))

    <div class="alert alert-danger border-0 shadow-sm">

        <i class="bi bi-exclamation-triangle-fill me-2"></i>

        {{ session('error') }}

    </div>

    @endif


    {{-- Informasi Pinjaman --}}
    <div class="card border-0 shadow-sm overflow-hidden">

        <div class="card-header bg-primary text-white py-3">

            <div class="d-flex align-items-center">

                <div class="bg-white bg-opacity-25 rounded-3 p-2 me-3">

                    <i class="bi bi-pencil-square fs-4"></i>

                </div>

                <div>

                    <h5 class="mb-0 fw-semibold">
                        Informasi Pinjaman
                    </h5>

                    <small class="opacity-75">
                        Perbarui informasi pinjaman dengan benar
                    </small>

                </div>

            </div>

        </div>


        <div class="card-body p-4">

            <form
                action="{{ route('pinjaman.update', $pinjaman) }}"
                method="POST">

                @csrf

                @method('PUT')


                <div class="row g-4">


                    {{-- Nomor Pinjaman --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nomor Pinjaman
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-hash text-primary"></i>
                            </span>

                            <input
                                type="text"
                                class="form-control bg-light"
                                value="{{ $pinjaman->no_pinjaman }}"
                                readonly>

                        </div>

                        <small class="text-muted">
                            Nomor pinjaman dibuat otomatis oleh sistem.
                        </small>

                    </div>


                    {{-- Anggota --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Anggota
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-person text-primary"></i>
                            </span>

                            <select
                                name="id_anggota"
                                class="form-select @error('id_anggota') is-invalid @enderror"
                                required>

                                <option value="">
                                    -- Pilih Anggota --
                                </option>

                                @foreach($anggotas as $anggota)

                                <option
                                    value="{{ $anggota->id_anggota }}"
                                    {{ old('id_anggota', $pinjaman->id_anggota) == $anggota->id_anggota ? 'selected' : '' }}>

                                    {{ $anggota->nama }}
                                    - {{ $anggota->kode_anggota }}

                                </option>

                                @endforeach

                            </select>

                            @error('id_anggota')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Tanggal Pinjaman --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Tanggal Pinjaman
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-calendar-event text-primary"></i>
                            </span>

                            <input
                                type="date"
                                name="tanggal_pinjaman"
                                class="form-control @error('tanggal_pinjaman') is-invalid @enderror"
                                value="{{ old(
                                'tanggal_pinjaman',
                                optional($pinjaman->tanggal_pinjaman)->format('Y-m-d')
                            ) }}"
                                required>

                            @error('tanggal_pinjaman')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Jumlah Pinjaman --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Jumlah Pinjaman
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <strong class="text-primary">
                                    Rp
                                </strong>
                            </span>

                            <input
                                type="number"
                                name="jumlah_pinjaman"
                                class="form-control @error('jumlah_pinjaman') is-invalid @enderror"
                                value="{{ old('jumlah_pinjaman', $pinjaman->jumlah_pinjaman) }}"
                                min="1"
                                step="0.01"
                                required>

                            @error('jumlah_pinjaman')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Bunga --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Bunga
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-percent text-primary"></i>
                            </span>

                            <input
                                type="number"
                                name="bunga_persen"
                                class="form-control @error('bunga_persen') is-invalid @enderror"
                                value="{{ old('bunga_persen', $pinjaman->bunga_persen) }}"
                                min="0"
                                step="0.01"
                                required>

                            <span class="input-group-text">
                                %
                            </span>

                            @error('bunga_persen')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror

                        </div>

                        <small class="text-muted">
                            Bunga dihitung secara flat dari pokok pinjaman.
                        </small>

                    </div>


                    {{-- Tenor --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Tenor
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-calendar-range text-primary"></i>
                            </span>

                            <input
                                type="number"
                                name="tenor"
                                class="form-control @error('tenor') is-invalid @enderror"
                                value="{{ old('tenor', $pinjaman->tenor) }}"
                                min="1"
                                required>

                            <span class="input-group-text">
                                Kali
                            </span>

                            @error('tenor')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Periode --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Periode Angsuran
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-clock-history text-primary"></i>
                            </span>

                            <input
                                type="number"
                                name="periode_hari"
                                class="form-control @error('periode_hari') is-invalid @enderror"
                                value="{{ old('periode_hari', $pinjaman->periode_hari) }}"
                                min="1"
                                required>

                            <span class="input-group-text">
                                Hari
                            </span>

                            @error('periode_hari')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror

                        </div>

                        <small class="text-muted">
                            Contoh: 35 hari untuk sistem satu selapan.
                        </small>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light">
                                <i class="bi bi-toggle-on text-primary"></i>
                            </span>

                            <input
                                type="text"
                                class="form-control bg-light"
                                value="{{ ucfirst(str_replace('_', ' ', $pinjaman->status)) }}"
                                readonly>

                        </div>

                        <small class="text-muted">
                            Status dikelola oleh sistem.
                        </small>

                    </div>

                </div>


                {{-- Informasi Perhitungan --}}
                <div class="alert alert-info border-0 mt-4 mb-0">

                    <div class="d-flex">

                        <i class="bi bi-info-circle-fill fs-5 me-3"></i>

                        <div>

                            <strong>
                                Perhatian
                            </strong>

                            <div class="small mt-1">

                                Setelah data diperbarui, jadwal angsuran akan
                                dihitung ulang berdasarkan jumlah pinjaman,
                                bunga, tenor, tanggal pinjaman, dan periode
                                angsuran.

                            </div>

                        </div>

                    </div>

                </div>


                <hr class="my-4">


                {{-- Footer --}}
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">

                    <div class="text-muted small">

                        <i class="bi bi-shield-check me-1"></i>

                        Perubahan hanya diperbolehkan jika belum ada pembayaran.

                    </div>


                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('pinjaman.show', $pinjaman) }}"
                            class="btn btn-light border">

                            <i class="bi bi-x-lg me-1"></i>

                            Batal

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary px-4">

                            <i class="bi bi-check-lg me-1"></i>

                            Simpan Perubahan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>
    ```

</div>

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