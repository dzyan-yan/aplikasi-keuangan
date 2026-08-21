@extends('layouts.app')

@section('title', 'Pengeluaran')

@section('page-title', 'Pengeluaran')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Data Pengeluaran
        </h3>

        <p class="text-muted mb-0">
            Kelola seluruh pengeluaran organisasi.
        </p>

    </div>


    <div class="d-flex gap-2">

        {{-- Tambah Pengeluaran --}}
        @if(in_array(session('admin_role'), ['superadmin', 'bendahara' ]))

        <a href="{{ route('pengeluaran.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>
            Tambah Pengeluaran

        </a>

        @endif


        {{-- Export --}}
        @if(in_array(session('admin_role'), ['superadmin', 'admin', 'bendahara', ]))

        <a href="{{ route('pengeluaran.export', [
                'bulan' => request('bulan'),
                'tahun' => request('tahun'),
                'kategori' => request('kategori'),
                'search' => request('search')
            ]) }}"
            class="btn btn-success shadow-sm">

            <i class="bi bi-file-earmark-excel me-1"></i>
            Export Excel

        </a>

        @endif

    </div>

</div>


{{-- ========================================================= --}}
{{-- ALERT --}}
{{-- ========================================================= --}}

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    <i class="bi bi-check-circle me-2"></i>

    {{ session('success') }}

    <button type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

@endif


{{-- ========================================================= --}}
{{-- FILTER --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white py-3">

        <strong>

            <i class="bi bi-funnel me-2"></i>

            Filter Pengeluaran

        </strong>

    </div>


    <div class="card-body">

        <form method="GET"
            action="{{ route('pengeluaran.index') }}">

            <div class="row g-3 align-items-end">


                {{-- BULAN --}}

                <div class="col-md-2">

                    <label class="form-label">
                        Bulan
                    </label>

                    <select name="bulan"
                        class="form-select">

                        <option value="">
                            Semua Bulan
                        </option>

                        @for($i = 1; $i <= 12; $i++)

                            <option value="{{ $i }}"
                            {{ request('bulan') == $i
                                    ? 'selected'
                                    : '' }}>

                            {{ \Carbon\Carbon::create()
                                    ->month($i)
                                    ->translatedFormat('F') }}

                            </option>

                            @endfor

                    </select>

                </div>


                {{-- TAHUN --}}

                <div class="col-md-2">

                    <label class="form-label">
                        Tahun
                    </label>

                    <select name="tahun"
                        class="form-select">

                        <option value="">
                            Semua Tahun
                        </option>

                        @for(
                        $tahun = date('Y');
                        $tahun >= date('Y') - 5;
                        $tahun--
                        )

                        <option value="{{ $tahun }}"
                            {{ request('tahun') == $tahun
                                    ? 'selected'
                                    : '' }}>

                            {{ $tahun }}

                        </option>

                        @endfor

                    </select>

                </div>


                {{-- KATEGORI --}}

                <div class="col-md-3">

                    <label class="form-label">
                        Kategori
                    </label>

                    <select name="kategori"
                        class="form-select">

                        <option value="">
                            Semua Kategori
                        </option>

                        @foreach($kategori as $item)

                        <option value="{{ $item }}"
                            {{ request('kategori') === $item
                                    ? 'selected'
                                    : '' }}>

                            {{ $item }}

                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- SEARCH --}}

                <div class="col-md-3">

                    <label class="form-label">
                        Pencarian
                    </label>

                    <input type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Keperluan / keterangan...">

                </div>


                {{-- BUTTON --}}

                <div class="col-md-2">

                    <div class="d-flex gap-2">

                        <button type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-search"></i>

                        </button>

                        <a href="{{ route('pengeluaran.index') }}"
                            class="btn btn-secondary">

                            <i class="bi bi-arrow-counterclockwise"></i>

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- TOTAL --}}
{{-- ========================================================= --}}

<div class="row g-3 mb-4">

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Total Pengeluaran
                        </small>

                        <h4 class="text-danger mb-0">

                            Rp {{ number_format(
                                $totalPengeluaran,
                                0,
                                ',',
                                '.'
                            ) }}

                        </h4>

                    </div>

                    <div class="fs-2 text-danger">

                        <i class="bi bi-wallet2"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">
                    Jumlah Transaksi
                </small>

                <h4 class="mb-0">

                    {{ $pengeluarans->total() }}

                </h4>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- TABEL --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <strong>

            <i class="bi bi-receipt me-2"></i>

            Daftar Pengeluaran

        </strong>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

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
                            Keperluan
                        </th>

                        <th>
                            Keterangan
                        </th>

                        <th>
                            Jumlah
                        </th>

                        <th>
                            Admin
                        </th>

                        <th width="160">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($pengeluarans as $pengeluaran)

                    <tr>


                        {{-- NO --}}

                        <td>

                            {{ $pengeluarans->firstItem()
                                + $loop->index }}

                        </td>


                        {{-- TANGGAL --}}

                        <td>

                            {{ $pengeluaran->tanggal
                                ? $pengeluaran->tanggal
                                    ->format('d-m-Y')
                                : '-' }}

                        </td>


                        {{-- KATEGORI --}}

                        <td>

                            <span class="badge bg-secondary">

                                {{ $pengeluaran->kategori }}

                            </span>

                        </td>


                        {{-- KEPERLUAN --}}

                        <td>

                            {{ $pengeluaran->keperluan ?? '-' }}

                        </td>


                        {{-- KETERANGAN --}}

                        <td>

                            {{ $pengeluaran->keterangan ?? '-' }}

                        </td>


                        {{-- JUMLAH --}}

                        <td>

                            <strong class="text-danger">

                                Rp {{ number_format(
                                    $pengeluaran->jumlah,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </strong>

                        </td>


                        {{-- ADMIN --}}

                        <td>

                            {{ $pengeluaran->admin->nama
                                ?? '-' }}

                        </td>


                        {{-- AKSI --}}

                        <td>

                            <div class="d-flex gap-1">


                                {{-- DETAIL --}}

                                <a href="{{ route(
                                        'pengeluaran.show',
                                        $pengeluaran
                                    ) }}"
                                    class="btn btn-sm btn-info text-white"
                                    title="Detail">

                                    <i class="bi bi-eye"></i>

                                </a>

                                {{-- EDIT & HAPUS --}}
                                @if(in_array(session('admin_role'), ['superadmin','bendahara']))

                                {{-- EDIT --}}
                                <a href="{{ route( 'pengeluaran.edit', $pengeluaran) }}"
                                    class="btn btn-sm btn-warning"
                                    title="Edit">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                {{-- HAPUS --}}
                                <form action="{{ route(
                'pengeluaran.destroy',
                $pengeluaran
            ) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm(
              'Yakin ingin menghapus pengeluaran ini?'
          );">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        title="Hapus">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                                @endif


                            </div>

                        </td>


                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-5">

                            <div class="text-muted">

                                <i class="bi bi-wallet2 fs-1"></i>

                                <p class="mt-3 mb-0">

                                    Belum ada data pengeluaran.

                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- PAGINATION --}}

    @if($pengeluarans->hasPages())

    <div class="card-footer bg-white">

        {{ $pengeluarans->links() }}

    </div>

    @endif

</div>

@endsection