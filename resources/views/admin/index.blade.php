@extends('layouts.app')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Manajemen User
        </h3>

        <p class="text-muted mb-0">
            Kelola akun administrator dan hak akses sistem.
        </p>

    </div>


    <a
        href="{{ route('admin.create') }}"
        class="btn btn-primary">

        <i class="bi bi-person-plus me-1"></i>

        Tambah User

    </a>

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

    <i class="bi bi-exclamation-triangle me-2"></i>

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

        <strong>

            <i class="bi bi-people me-2"></i>

            Daftar User

        </strong>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th width="60">
                            #
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            Username
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Dibuat
                        </th>

                        <th
                            class="text-end"
                            width="180">

                            Aksi

                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($admins as $admin)

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>


                        <td>

                            <div class="d-flex align-items-center">

                                <div
                                    class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width:40px;height:40px;">

                                    {{ strtoupper(
                                        substr(
                                            $admin->nama,
                                            0,
                                            1
                                        )
                                    ) }}

                                </div>

                                <div>

                                    <div class="fw-bold">

                                        {{ $admin->nama }}

                                        @if(
                                        session('admin_id')
                                        == $admin->id_admin
                                        )

                                        <span class="badge bg-success ms-1">

                                            Anda

                                        </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </td>


                        <td>

                            <code>

                                {{ $admin->username }}

                            </code>

                        </td>


                        <td>

                            @if($admin->role === 'superadmin')

                            <span class="badge bg-danger">

                                <i class="bi bi-shield-fill-check me-1"></i>

                                Superadmin

                            </span>

                            @elseif($admin->role === 'bendahara')

                            <span class="badge bg-success">

                                <i class="bi bi-cash-stack me-1"></i>

                                Bendahara

                            </span>

                            @elseif($admin->role === 'pengurus')

                            <span class="badge bg-info text-dark">

                                <i class="bi bi-person-badge me-1"></i>

                                Pengurus

                            </span>

                            @else

                            <span class="badge bg-secondary">

                                <i class="bi bi-person me-1"></i>

                                Admin

                            </span>

                            @endif

                        </td>


                        <td>

                            {{ $admin->created_at
                                ? $admin->created_at->format(
                                    'd-m-Y H:i'
                                )
                                : '-'
                            }}

                        </td>


                        <td class="text-end">

                            <div class="d-flex justify-content-end gap-1">

                                <a
                                    href="{{ route(
                                        'admin.edit',
                                        $admin
                                    ) }}"
                                    class="btn btn-sm btn-warning">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                @if(
                                session('admin_id')
                                != $admin->id_admin
                                )

                                <form
                                    action="{{ route(
                                        'admin.destroy',
                                        $admin
                                    ) }}"
                                    method="POST"
                                    onsubmit="return confirm(
                                        'Yakin ingin menghapus user ini?'
                                    );">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="6"
                            class="text-center py-5 text-muted">

                            <i class="bi bi-people fs-1 d-block mb-2"></i>

                            Belum ada user.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection