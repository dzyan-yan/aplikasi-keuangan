@extends('layouts.app')

@section('title', 'Sebrakan')

@section('page-title', 'Sebrakan')

@section('content')

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-cash-coin text-primary me-2"></i>
                Sebrakan
            </h4>

            <p class="text-muted mb-0">
                Kelola sebrakan anggota dengan sistem bunga 5% per selapan.
            </p>
        </div>

        <div class="mt-3 mt-md-0">
            @if(in_array(session('admin_role'), ['superadmin', 'admin', 'bendahara']))
            <a href="{{ route('sebrakan.create') }}"
                class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Tambah sebrakan
            </a>
            @endif
        </div>

    </div>


    {{-- Alert --}}
    @if(session('success'))

    <div class="alert alert-success border-0 shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
    </div>

    @endif


    @if(session('error'))

    <div class="alert alert-danger border-0 shadow-sm">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
    </div>

    @endif


    {{-- Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <strong>
                    <i class="bi bi-list-ul text-primary me-2"></i>
                    Daftar Sebrakan
                </strong>

                <span class="badge bg-primary">
                    {{ $sebrakans->count() }} Data
                </span>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="text-center">No</th>

                            <th>Anggota</th>

                            <th>Tanggal</th>

                            <th>Jatuh Tempo</th>

                            <th class="text-end">Pokok</th>

                            <th class="text-end">Bunga</th>

                            <th class="text-end">Total</th>

                            <th class="text-end">Dibayar</th>

                            <th class="text-center">Status</th>

                            <th class="text-center">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($sebrakans as $sebrakan)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                <div class="fw-semibold">
                                    {{ $sebrakan->anggota->nama ?? '-' }}
                                </div>

                                <small class="text-muted">
                                    {{ $sebrakan->anggota->kode_anggota ?? '-' }}
                                </small>

                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($sebrakan->tanggal_sebrakan)->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($sebrakan->tanggal_jatuh_tempo)->format('d/m/Y') }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($sebrakan->pokok, 0, ',', '.') }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($sebrakan->bunga, 0, ',', '.') }}
                            </td>

                            <td class="text-end fw-semibold">
                                Rp {{ number_format($sebrakan->total, 0, ',', '.') }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($sebrakan->jumlah_bayar ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="text-center">

                                @if($sebrakan->status === 'lunas')

                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Lunas
                                </span>

                                @elseif($sebrakan->status === 'terlambat')

                                <span class="badge bg-danger">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    Terlambat
                                </span>

                                @else

                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock me-1"></i>
                                    Belum Bayar
                                </span>

                                @endif

                            </td>

                            <td class="text-center">

                                <div class="btn-group">

                                    {{-- Detail --}}
                                    <a href="{{ route('sebrakan.show', $sebrakan->id_sebrakan) }}"
                                        class="btn btn-sm btn-outline-secondary"
                                        title="Detail">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- Bayar --}}

                                    @if(in_array(session('admin_role'), ['superadmin', 'bendahara']))
                                    @if($sebrakan->status !== 'lunas')

                                    <form action="{{ route('sebrakan.bayar', $sebrakan->id_sebrakan) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        <input type="hidden"
                                            name="tanggal_bayar"
                                            value="{{ now()->format('Y-m-d') }}">

                                        <button type="submit"
                                            class="btn btn-sm btn-outline-success"
                                            onclick="return confirm('Bayar sebrakan ini sampai lunas?')"
                                            title="Bayar"> Bayar

                                            <i class="bi bi-cash-stack"></i>

                                        </button>

                                    </form>
                                    @endif
                                    @else
                                    @if(in_array(session('admin_role'), ['superadmin', 'bendahara']))
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Lunas
                                    </span>

                                    @endif
                                    @endif

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="10" class="text-center py-5">

                                <div class="text-muted">

                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                                    <div class="fw-semibold">
                                        Belum ada data sebrakan
                                    </div>

                                    <small>
                                        Silakan tambahkan sebrakan baru.
                                    </small>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<style>
    .card {
        border-radius: 12px;
    }

    .card-header {
        border-bottom: 1px solid #f0f0f0;
    }

    .table th {
        white-space: nowrap;
        font-size: .85rem;
    }

    .table td {
        font-size: .9rem;
    }

    .btn {
        border-radius: 7px;
    }

    .badge {
        font-weight: 500;
    }
</style>

@endsection