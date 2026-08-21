@extends('layouts.app')

@section('title', 'Pembayaran Angsuran')

@section('page-title', 'Pembayaran Angsuran')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">
            Pembayaran Angsuran
        </h3>

        <p class="text-muted mb-0">
            Input pembayaran angsuran anggota.
        </p>
    </div>

    <a href="{{ url()->previous() }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>


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


<div class="row">


    {{-- INFORMASI ANGSURAN --}}

    <div class="col-md-5 mb-4">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <strong>
                    <i class="bi bi-info-circle me-2"></i>
                    Informasi Angsuran
                </strong>

            </div>


            <div class="card-body">

                <div class="mb-3">

                    <small class="text-muted">
                        Anggota
                    </small>

                    <div class="fw-bold">
                        {{ $angsuran->pinjaman->anggota->nama }}
                    </div>

                    <small class="text-muted">
                        {{ $angsuran->pinjaman->anggota->kode_anggota }}
                    </small>

                </div>


                <div class="mb-3">

                    <small class="text-muted">
                        No. Pinjaman
                    </small>

                    <div class="fw-bold">
                        {{ $angsuran->pinjaman->no_pinjaman }}
                    </div>

                </div>


                <div class="mb-3">

                    <small class="text-muted">
                        Angsuran Ke
                    </small>

                    <div class="fw-bold">
                        {{ $angsuran->angsuran_ke }}
                        / {{ $angsuran->pinjaman->tenor }}
                    </div>

                </div>


                <div class="mb-3">

                    <small class="text-muted">
                        Jatuh Tempo
                    </small>

                    <div>
                        {{ \Carbon\Carbon::parse($angsuran->jatuh_tempo)->format('d-m-Y') }}
                    </div>

                </div>


                <hr>


                <div class="d-flex justify-content-between mb-2">

                    <span>
                        Tagihan
                    </span>

                    <strong>
                        Rp {{ number_format($angsuran->jumlah_angsuran, 0, ',', '.') }}
                    </strong>

                </div>


                <div class="d-flex justify-content-between mb-2">

                    <span class="text-success">
                        Sudah Dibayar
                    </span>

                    <strong class="text-success">

                        Rp {{ number_format(
                            $angsuran->jumlah_dibayar,
                            0,
                            ',',
                            '.'
                        ) }}

                    </strong>

                </div>


                <div class="d-flex justify-content-between">

                    <span class="text-danger">
                        Sisa
                    </span>

                    <strong class="text-danger">

                        Rp {{ number_format(
                            $sisa,
                            0,
                            ',',
                            '.'
                        ) }}

                    </strong>

                </div>

            </div>

        </div>

    </div>



    {{-- FORM PEMBAYARAN --}}

    <div class="col-md-7 mb-4">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <strong>
                    <i class="bi bi-cash-coin me-2"></i>
                    Form Pembayaran
                </strong>

            </div>


            <div class="card-body">

                <form
                    action="{{ route('angsuran.bayar.store', $angsuran) }}"
                    method="POST">

                    @csrf


                    {{-- TANGGAL BAYAR --}}

                    <div class="mb-3">

                        <label class="form-label">
                            Tanggal Bayar
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal_bayar"
                            class="form-control"
                            value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                            required>

                    </div>


                    {{-- JUMLAH BAYAR --}}

                    <div class="mb-3">

                        <label class="form-label">
                            Jumlah Bayar
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="number"
                                name="jumlah_bayar"
                                id="jumlah_bayar"
                                class="form-control"
                                value="{{ old('jumlah_bayar', $sisa) }}"
                                min="1"
                                max="{{ $sisa }}"
                                required>

                        </div>

                        <small class="text-muted">
                            Maksimal pembayaran:
                            Rp {{ number_format($sisa, 0, ',', '.') }}
                        </small>

                    </div>


                    {{-- DENDA --}}

                    <div class="mb-3">

                        <label class="form-label">
                            Denda
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="number"
                                name="denda"
                                class="form-control"
                                value="{{ old('denda', 0) }}"
                                min="0">

                        </div>

                    </div>


                    {{-- KETERANGAN --}}

                    <div class="mb-4">

                        <label class="form-label">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="3"
                            placeholder="Keterangan pembayaran...">{{ old('keterangan') }}</textarea>

                    </div>


                    <div class="d-flex justify-content-end gap-2">

                        <a
                            href="{{ url()->previous() }}"
                            class="btn btn-secondary">

                            Batal

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-check-circle me-1"></i>

                            Simpan Pembayaran

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection