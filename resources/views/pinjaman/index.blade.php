@extends('layouts.app')

@section('title', 'Pinjaman')

@section('page-title', 'Pinjaman')

@section('content')


@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    <i class="bi bi-check-circle me-2"></i>

    {{ session('success') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

@endif


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">Data Pinjaman</h3>

        <p class="text-muted mb-0">
            Kelola data pinjaman anggota.
        </p>
    </div>

    @if(in_array(session('admin_role'), ['superadmin', 'bendahara']))
    <a href="{{ route('pinjaman.create') }}"
        class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>
        Tambah Pinjaman
    </a>
    @endif

</div>


<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>No</th>

                        <th>No. Pinjaman</th>

                        <th>Anggota</th>

                        <th>Tanggal</th>

                        <th>Jumlah Pinjaman</th>

                        <th>Angsuran</th>

                        <th>Status</th>

                        <th width="150">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($pinjamans as $pinjaman)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>

                            <strong>
                                {{ $pinjaman->no_pinjaman }}
                            </strong>

                        </td>

                        <td>

                            {{ $pinjaman->anggota->nama ?? '-' }}

                        </td>

                        <td>

                            {{ $pinjaman->tanggal_pinjaman
                                    ? $pinjaman->tanggal_pinjaman->format('d-m-Y')
                                    : '-'
                                }}

                        </td>

                        <td>

                            Rp
                            {{ number_format(
                                    $pinjaman->jumlah_pinjaman,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                        </td>

                        <td>

                            Rp
                            {{ number_format(
                                    $pinjaman->jumlah_angsuran,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                        </td>

                        <td>

                            @if($pinjaman->status === 'aktif')

                            <span class="badge bg-primary">
                                Aktif
                            </span>

                            @elseif($pinjaman->status === 'lunas')

                            <span class="badge bg-success">
                                Lunas
                            </span>

                            @else

                            <span class="badge bg-secondary">
                                Dibatalkan
                            </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route(
                                    'pinjaman.show',
                                    $pinjaman->id_pinjaman
                                ) }}"
                                class="btn btn-sm btn-info text-white"
                                title="Detail">

                                <i class="bi bi-eye"></i>

                            </a>

                            @if(in_array(session('admin_role'), ['superadmin', 'bendahara']))
                            <a href="{{ route('pinjaman.edit', $pinjaman) }}"
                                class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endif

                            @if(in_array(session('admin_role'), ['superadmin', 'admin', 'bendahara']))
                            <form action="{{ route('pinjaman.destroy', $pinjaman) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>
                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-5">

                            <i
                                class="bi bi-cash-stack fs-1 text-muted">
                            </i>

                            <h5 class="mt-3">
                                Belum Ada Pinjaman
                            </h5>

                            <p class="text-muted">
                                Belum ada data pinjaman.
                            </p>

                            @if(in_array(session('admin_role'), ['superadmin', 'admin', 'bendahara']))
                            <a href="{{ route('pinjaman.create') }}"
                                class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>
                                Tambah Pinjaman
                            </a>
                            @endif

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection