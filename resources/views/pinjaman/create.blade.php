@extends('layouts.app')

@section('title', 'Tambah Pinjaman')

@section('page-title', 'Tambah Pinjaman')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">Tambah Pinjaman</h3>

        <p class="text-muted mb-0">
            Buat pinjaman baru untuk anggota.
        </p>
    </div>

    <a href="{{ route('pinjaman.index') }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form action="{{ route('pinjaman.store') }}" method="POST">

            @csrf

            <div class="row">

                {{-- ANGGOTA --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Anggota <span class="text-danger">*</span>
                    </label>

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
                            {{ old('id_anggota') == $anggota->id_anggota ? 'selected' : '' }}>

                            {{ $anggota->kode_anggota }}
                            -
                            {{ $anggota->nama }}

                        </option>

                        @endforeach

                    </select>

                    @error('id_anggota')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- TANGGAL --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Tanggal Pinjaman
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="tanggal_pinjaman"
                        value="{{ old('tanggal_pinjaman', date('Y-m-d')) }}"
                        class="form-control @error('tanggal_pinjaman') is-invalid @enderror"
                        required>

                    @error('tanggal_pinjaman')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- JUMLAH PINJAMAN --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Jumlah Pinjaman
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="number"
                        name="jumlah_pinjaman"
                        id="jumlah_pinjaman"
                        value="{{ old('jumlah_pinjaman') }}"
                        min="0"
                        step="1000"
                        class="form-control @error('jumlah_pinjaman') is-invalid @enderror"
                        placeholder="Contoh: 1000000"
                        required>

                    @error('jumlah_pinjaman')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Bunga
                    </label>

                    <div class="form-control bg-light">
                        <strong>20%</strong> Flat
                    </div>

                    <input type="hidden"
                        name="bunga_persen"
                        value="20">

                </div>


                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Tenor
                    </label>

                    <div class="form-control bg-light">
                        <strong>12 Kali</strong>
                    </div>

                    <input type="hidden"
                        name="tenor"
                        value="12">

                </div>


                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Periode Angsuran
                    </label>

                    <div class="form-control bg-light">
                        <strong>35 Hari</strong>
                    </div>

                    <input type="hidden"
                        name="periode_hari"
                        value="35">

                    <small class="text-muted">
                        Selapan
                    </small>

                </div>

            </div>

    </div>


    <hr class="my-4">


    {{-- PREVIEW PERHITUNGAN --}}

    <h5 class="mb-3">
        <i class="bi bi-calculator me-2"></i>
        Perhitungan Pinjaman
    </h5>


    <div class="row g-3">

        <div class="col-md-3">

            <div class="border rounded p-3">

                <small class="text-muted">
                    Pokok Pinjaman
                </small>

                <div
                    id="preview_pokok"
                    class="fs-5 fw-bold">

                    Rp 0

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="border rounded p-3">

                <small class="text-muted">
                    Jumlah Bunga
                </small>

                <div
                    id="preview_bunga"
                    class="fs-5 fw-bold">

                    Rp 0

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="border rounded p-3">

                <small class="text-muted">
                    Total Pinjaman
                </small>

                <div
                    id="preview_total"
                    class="fs-5 fw-bold">

                    Rp 0

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="border rounded p-3">

                <small class="text-muted">
                    Angsuran / Periode
                </small>

                <div
                    id="preview_angsuran"
                    class="fs-5 fw-bold">

                    Rp 0

                </div>

            </div>

        </div>

    </div>


    <div class="mt-4 text-end">

        <button
            type="submit"
            class="btn btn-primary">

            <i class="bi bi-save me-1"></i>

            Simpan Pinjaman

        </button>

    </div>

    </form>

</div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const jumlahInput = document.getElementById('jumlah_pinjaman');
        const bungaInput = document.getElementById('bunga_persen');
        const tenorInput = document.getElementById('tenor');

        const pokok = document.getElementById('preview_pokok');
        const bunga = document.getElementById('preview_bunga');
        const total = document.getElementById('preview_total');
        const angsuran = document.getElementById('preview_angsuran');


        function rupiah(value) {

            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);

        }


        function hitung() {

            const jumlah = parseFloat(jumlahInput.value) || 0;
            const persen = parseFloat(bungaInput.value) || 0;
            const tenor = parseInt(tenorInput.value) || 1;


            const jumlahBunga = jumlah * persen / 100;

            const totalPinjaman = jumlah + jumlahBunga;

            const jumlahAngsuran = totalPinjaman / tenor;


            pokok.textContent = rupiah(jumlah);

            bunga.textContent = rupiah(jumlahBunga);

            total.textContent = rupiah(totalPinjaman);

            angsuran.textContent = rupiah(jumlahAngsuran);

        }


        jumlahInput.addEventListener('input', hitung);

        bungaInput.addEventListener('input', hitung);

        tenorInput.addEventListener('input', hitung);


        hitung();

    });
</script>

@endsection