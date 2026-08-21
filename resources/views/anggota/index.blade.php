@extends('layouts.app')

@section('title', 'Anggota')

@section('page-title', 'Anggota')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">Data Anggota</h3>

        <p class="text-muted mb-0">
            Kelola data anggota aplikasi angsuran.
        </p>
    </div>

    @if(in_array(session('admin_role'), ['superadmin', 'admin', 'bendahara']))
    <a href="{{ route('anggota.create') }}"
        class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>
        Tambah anggota
    </a>
    @endif

</div>


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


@if(session('error'))

<div class="alert alert-danger alert-dismissible fade show">

    <i class="bi bi-exclamation-circle me-2"></i>

    {{ session('error') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

@endif


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <strong>
                <i class="bi bi-people me-2"></i>
                Daftar Anggota
            </strong>

            <span class="badge bg-primary">

                {{ $anggotas->count() }}

                Anggota

            </span>

        </div>

    </div>


    <div class="card-body">

        @if($anggotas->count() > 0)

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Kode
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            NIK
                        </th>

                        <th>
                            No. HP
                        </th>

                        <th>
                            Tanggal Daftar
                        </th>

                        <th>
                            Status
                        </th>

                        <th
                            width="180"
                            class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($anggotas as $index => $anggota)

                    <tr>

                        <td>
                            {{ $index + 1 }}
                        </td>

                        <td>

                            <span class="badge bg-secondary">

                                {{ $anggota->kode_anggota }}

                            </span>

                        </td>

                        <td>

                            <strong>
                                {{ $anggota->nama }}
                            </strong>

                        </td>

                        <td>

                            {{ $anggota->nik ?? '-' }}

                        </td>

                        <td>

                            {{ $anggota->no_hp ?? '-' }}

                        </td>

                        <td>

                            {{ $anggota->tanggal_daftar
                                        ? $anggota->tanggal_daftar->format('d-m-Y')
                                        : '-'
                                    }}

                        </td>

                        <td>

                            @if($anggota->status === 'aktif')

                            <span class="badge bg-success">
                                Aktif
                            </span>

                            @else

                            <span class="badge bg-secondary">
                                Tidak Aktif
                            </span>

                            @endif

                        </td>

                        <td class="text-center">

                            <div class="btn-group">

                                {{-- DETAIL --}}

                                <a
                                    href="{{ route('anggota.show', [
    'anggota' => $anggota->id_anggota
]) }}"
                                    class="btn btn-sm btn-info text-white"
                                    title="Detail">

                                    <i class="bi bi-eye"></i>

                                </a>


                                {{-- EDIT --}}
                                @if(in_array(session('admin_role'), ['superadmin', 'admin', 'bendahara']))
                                <a href="{{ route('anggota.edit', [    'anggota' => $anggota->id_anggota
]) }}"
                                    class="btn btn-sm btn-warning"
                                    title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif







                                {{-- HAPUS --}}
                                @if(in_array(session('admin_role'), ['superadmin', 'admin', 'bendahara']))

                                <form
                                    action="{{ route('anggota.destroy', [    'anggota' => $anggota->id_anggota
]) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm(
                                                'Yakin ingin menghapus anggota ini?'
                                            );">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        title="Hapus">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>
                                @endif


                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        @else

        <div class="text-center py-5">

            <div class="mb-3">

                <i
                    class="bi bi-people"
                    style="font-size: 50px;">
                </i>

            </div>

            <h5>
                Belum Ada Anggota
            </h5>

            <p class="text-muted">

                Belum ada data anggota yang terdaftar.

            </p>

            @if(in_array(session('admin_role'), ['superadmin', 'admin', 'bendahara']))
            <a href="{{ route('anggota.create') }}"
                class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Anggota Pertama
            </a>
            @endif

        </div>

        @endif

    </div>

</div>

@endsection