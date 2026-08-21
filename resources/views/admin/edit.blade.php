@extends('layouts.app')

@section('title', 'Edit User')

@section('page-title', 'Edit User')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Edit User
        </h3>

        <p class="text-muted mb-0">
            Ubah informasi dan hak akses user.
        </p>

    </div>


    <a
        href="{{ route('admin.index') }}"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left me-1"></i>

        Kembali

    </a>

</div>


@if($errors->any())

<div class="alert alert-danger">

    <strong>
        Terdapat kesalahan:
    </strong>

    <ul class="mb-0 mt-2">

        @foreach($errors->all() as $error)

        <li>
            {{ $error }}
        </li>

        @endforeach

    </ul>

</div>

@endif


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <strong>

            <i class="bi bi-person-gear me-2"></i>

            Edit User

        </strong>

    </div>


    <div class="card-body">

        <form
            action="{{ route(
                'admin.update',
                $admin
            ) }}"
            method="POST">

            @csrf

            @method('PUT')


            <div class="row">


                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Nama Lengkap

                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="{{ old(
                            'nama',
                            $admin->nama
                        ) }}"
                        required>

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Username

                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="{{ old(
                            'username',
                            $admin->username
                        ) }}"
                        required>

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Role

                        <span class="text-danger">*</span>

                    </label>

                    <select
                        name="role"
                        class="form-select"
                        required>

                        @foreach($roles as $role)

                        <option
                            value="{{ $role }}"
                            @selected(
                            old( 'role' ,
                            $admin->role
                            ) === $role
                            )>

                            {{ ucfirst($role) }}

                        </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-12">

                    <div class="alert alert-info">

                        <i class="bi bi-info-circle me-2"></i>

                        Kosongkan password jika tidak ingin
                        mengubah password user.

                    </div>

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Password Baru

                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control">

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Konfirmasi Password Baru

                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control">

                </div>


            </div>


            <hr class="my-4">


            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('admin.index') }}"
                    class="btn btn-secondary">

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