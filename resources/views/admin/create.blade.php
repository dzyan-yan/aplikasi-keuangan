@extends('layouts.app')

@section('title', 'Tambah User')

@section('page-title', 'Tambah User')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Tambah User
        </h3>

        <p class="text-muted mb-0">
            Buat akun baru untuk pengguna aplikasi.
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

            <i class="bi bi-person-plus me-2"></i>

            Form User Baru

        </strong>

    </div>


    <div class="card-body">

        <form
            action="{{ route('admin.store') }}"
            method="POST">

            @csrf


            <div class="row">


                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Nama Lengkap

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="{{ old('nama') }}"
                        required>

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Username

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        value="{{ old('username') }}"
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

                        <option value="">
                            -- Pilih Role --
                        </option>

                        @foreach($roles as $role)

                        <option
                            value="{{ $role }}"
                            @selected(
                            old('role')===$role
                            )>

                            {{ ucfirst($role) }}

                        </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-md-6">
                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Password

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>

                    <small class="text-muted">

                        Minimal 6 karakter.

                    </small>

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Konfirmasi Password

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        required>

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

                    Simpan User

                </button>

            </div>

        </form>

    </div>

</div>

@endsection