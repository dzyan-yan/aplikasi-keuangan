@extends('layouts.app')

@section('title', 'Pemasukan')

@section('page-title', 'Pemasukan')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Pemasukan
        </h3>

        <p class="text-muted mb-0">
            Kelola seluruh transaksi pemasukan organisasi.
        </p>

    </div>

    <div class="d-flex gap-2">
        @if(in_array(session('admin_role'), ['superadmin', 'admin', 'bendahara']))

        <a href="{{ route('pemasukan.export', [
        'bulan' => $bulan,
        'tahun' => $tahun,
        'kategori' => $kategori
    ]) }}"
            class="btn btn-success shadow-sm">

            <i class="bi bi-file-earmark-excel me-1"></i>
            Export Excel

        </a>
        @endif

        @if(in_array(session('admin_role'), ['superadmin', 'bendahara' ]))

        <a href="{{ route('pemasukan.create') }}"
            class="btn btn-primary shadow-sm">

            <i class="bi bi-plus-lg me-1"></i>
            Tambah Pemasukan

        </a>
        @ENDIF



    </div>

</div>


{{-- ========================================================= --}}
{{-- SUCCESS MESSAGE --}}
{{-- ========================================================= --}}

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    <i class="bi bi-check-circle me-1"></i>

    {{ session('success') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

@endif


{{-- ========================================================= --}}
{{-- ERROR MESSAGE --}}
{{-- ========================================================= --}}

@if(session('error'))

<div class="alert alert-danger alert-dismissible fade show">

    <i class="bi bi-exclamation-triangle me-1"></i>

    {{ session('error') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

@endif


{{-- ========================================================= --}}
{{-- RINGKASAN --}}
{{-- ========================================================= --}}

<div class="row g-3 mb-4">


    {{-- TOTAL PEMASUKAN --}}

    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Total Pemasukan
                        </small>

                        <h4 class="mb-0 text-success">

                            Rp
                            {{ number_format(
                                $totalPemasukan,
                                0,
                                ',',
                                '.'
                            ) }}

                        </h4>

                    </div>

                    <div class="text-success fs-2">

                        <i class="bi bi-wallet2"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- PEMASUKAN ANGSURAN --}}

    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Pemasukan Angsuran
                        </small>

                        <h4 class="mb-0 text-primary">

                            Rp
                            {{ number_format(
                                $totalAngsuran,
                                0,
                                ',',
                                '.'
                            ) }}

                        </h4>

                    </div>

                    <div class="text-primary fs-2">

                        <i class="bi bi-cash-stack"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- PEMASUKAN LAINNYA --}}

    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Pemasukan Lainnya
                        </small>

                        <h4 class="mb-0 text-info">

                            Rp
                            {{ number_format(
                                $totalLainnya,
                                0,
                                ',',
                                '.'
                            ) }}

                        </h4>

                    </div>

                    <div class="text-info fs-2">

                        <i class="bi bi-arrow-down-circle"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- FILTER --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white py-3">

        <strong>

            <i class="bi bi-funnel me-2"></i>

            Filter Pemasukan

        </strong>

    </div>


    <div class="card-body">

        <form
            method="GET"
            action="{{ route('pemasukan.index') }}">

            <div class="row g-3 align-items-end">


                {{-- BULAN --}}

                <div class="col-md-3">

                    <label class="form-label">
                        Bulan
                    </label>

                    <select
                        name="bulan"
                        class="form-select">

                        <option value="">
                            Semua Bulan
                        </option>

                        @foreach(range(1, 12) as $bulanItem)

                        <option
                            value="{{ $bulanItem }}"
                            {{ (string)$bulan === (string)$bulanItem
                                ? 'selected'
                                : '' }}>

                            {{ \Carbon\Carbon::create()
                                ->month($bulanItem)
                                ->translatedFormat('F') }}

                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- TAHUN --}}

                <div class="col-md-3">

                    <label class="form-label">
                        Tahun
                    </label>

                    <select
                        name="tahun"
                        class="form-select">

                        @foreach($daftarTahun as $tahunItem)

                        <option
                            value="{{ $tahunItem }}"
                            {{ (string)$tahun === (string)$tahunItem
                                ? 'selected'
                                : '' }}>

                            {{ $tahunItem }}

                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- KATEGORI --}}

                <div class="col-md-3">

                    <label class="form-label">
                        Kategori
                    </label>

                    <select
                        name="kategori"
                        class="form-select">

                        <option value="">
                            Semua Kategori
                        </option>

                        @foreach($daftarKategori as $kategoriItem)

                        <option
                            value="{{ $kategoriItem }}"
                            {{ $kategori === $kategoriItem
                                ? 'selected'
                                : '' }}>

                            {{ $kategoriItem }}

                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- BUTTON --}}

                <div class="col-md-3">

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>

                            Tampilkan

                        </button>


                        <a
                            href="{{ route('pemasukan.index') }}"
                            class="btn btn-secondary">

                            <i class="bi bi-arrow-clockwise"></i>

                        </a>

                    </div>

                </div>


            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- TABEL PEMASUKAN --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <strong>

                <i class="bi bi-list-ul me-2"></i>

                Data Pemasukan

            </strong>


            <span class="badge bg-success">

                {{ $pemasukans->count() }}
                Transaksi

            </span>

        </div>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table
                class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Kategori
                        </th>

                        <th>
                            Sumber
                        </th>

                        <th>
                            Keterangan
                        </th>

                        <th>
                            Jumlah
                        </th>

                        <th>
                            Jenis
                        </th>

                        <th>
                            Admin
                        </th>

                        <th width="150">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($pemasukans as $pemasukan)

                    <tr>


                        {{-- NO --}}

                        <td>

                            {{ $loop->iteration }}

                        </td>


                        {{-- TANGGAL --}}

                        <td>

                            {{ \Carbon\Carbon::parse(
                                $pemasukan->tanggal
                            )->format('d-m-Y') }}

                        </td>


                        {{-- KATEGORI --}}

                        <td>

                            @if($pemasukan->kategori === 'Angsuran')

                            <span class="badge bg-primary">

                                <i class="bi bi-cash-stack me-1"></i>

                                Angsuran

                            </span>

                            @elseif($pemasukan->kategori === 'Sewa')

                            <span class="badge bg-info text-dark">

                                Sewa

                            </span>

                            @elseif($pemasukan->kategori === 'Sebrakan')

                            <span class="badge bg-warning text-dark">

                                Sebrakan

                            </span>

                            @elseif($pemasukan->kategori === 'Donasi')

                            <span class="badge bg-success">

                                Donasi

                            </span>

                            @else

                            <span class="badge bg-secondary">

                                {{ $pemasukan->kategori }}

                            </span>

                            @endif

                        </td>


                        {{-- SUMBER --}}

                        <td>

                            {{ $pemasukan->sumber ?? '-' }}

                        </td>


                        {{-- KETERANGAN --}}

                        <td>

                            {{ $pemasukan->keterangan ?? '-' }}

                        </td>


                        {{-- JUMLAH --}}

                        <td>

                            <strong class="text-success">

                                Rp
                                {{ number_format(
                                    $pemasukan->jumlah,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </strong>

                        </td>


                        {{-- JENIS --}}

                        <td>
                            @if($pemasukan->referensi_type)
                            <span class="badge bg-primary">
                                <i class="bi bi-robot me-1"></i>
                                Otomatis
                            </span>
                            @else
                            <span class="badge bg-secondary">
                                <i class="bi bi-pencil me-1"></i>
                                Manual
                            </span>
                            @endif
                        </td>


                        {{-- ADMIN --}}

                        <td>

                            {{ $pemasukan->admin->nama ?? '-' }}

                        </td>


                        {{-- AKSI --}}

                        <td class="text-center">

                            <div class="btn-group">

                                {{-- Detail --}}

                                <a href="{{ route('pemasukan.show', $pemasukan) }}"
                                    class="btn btn-sm btn-info text-white"
                                    title="Detail">

                                    <i class="bi bi-eye"></i>

                                </a>


                                {{-- Edit & Hapus hanya untuk transaksi manual --}}
                                @if($pemasukan->referensi_type === null)

                                {{-- Edit --}}
                                @if(in_array(session('admin_role'), ['superadmin', 'bendahara']))

                                <a href="{{ route('pemasukan.edit', $pemasukan) }}"
                                    class="btn btn-sm btn-warning"
                                    title="Edit">

                                    <i class="bi bi-pencil"></i>

                                </a>
                                @endif


                                {{-- Hapus --}}
                                <form action="{{ route('pemasukan.destroy', $pemasukan) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    @if(in_array(session('admin_role'), ['superadmin', 'bendahara']))


                                    <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus pemasukan ini?')"
                                        title="Hapus">

                                        <i class="bi bi-trash"></i>

                                    </button>
                                    @endif

                                </form>

                                @else

                                {{-- Transaksi otomatis --}}
                                <span class="btn btn-sm btn-light text-muted"
                                    title="Transaksi otomatis tidak dapat diedit atau dihapus">

                                    <i class="bi bi-lock-fill"></i>

                                </span>

                                @endif

                            </div>

                        </td>


                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="9"
                            class="text-center py-5">

                            <div class="text-muted">

                                <i
                                    class="bi bi-wallet2 fs-1 d-block mb-3">
                                </i>

                                <div class="fw-bold">
                                    Belum ada data pemasukan.
                                </div>

                                <small>
                                    Silakan tambahkan transaksi pemasukan.
                                </small>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>


                {{-- TOTAL --}}

                @if($pemasukans->count() > 0)

                <tfoot class="table-light">

                    <tr>

                        <th
                            colspan="5"
                            class="text-end">

                            TOTAL

                        </th>

                        <th class="text-success">

                            Rp
                            {{ number_format(
                                $totalFilter,
                                0,
                                ',',
                                '.'
                            ) }}

                        </th>

                        <th colspan="3"></th>

                    </tr>

                </tfoot>

                @endif

            </table>

        </div>

    </div>

</div>

@endsection