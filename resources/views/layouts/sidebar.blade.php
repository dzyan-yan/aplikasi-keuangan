@php
$role = session('admin_role');
@endphp

<div class="sidebar">

    <div class="sidebar-brand">

        <i class="bi bi-wallet2"></i>

        <span class="ms-2">
            Aplikasi Angsuran
        </span>

    </div>


    <div class="sidebar-menu">

        {{-- =========================
             MENU UTAMA
        ========================== --}}

        <div class="menu-title">
            Menu Utama
        </div>

        <a href="{{ route('dashboard') }}"
            class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <i class="bi bi-speedometer2"></i>

            <span>Dashboard</span>

        </a>


        {{-- =========================
             MASTER DATA
        ========================== --}}

        @if(in_array($role, ['superadmin', 'admin', 'bendahara', 'pengurus']))

        <div class="menu-title">
            Master Data
        </div>

        <a href="{{ route('anggota.index') }}"
            class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">

            <i class="bi bi-people"></i>

            <span>Anggota</span>

        </a>

        @endif


        {{-- ADMIN HANYA SUPERADMIN --}}

        @if($role === 'superadmin')

        <a href="{{ route('admin.index') }}"
            class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">

            <i class="bi bi-person-gear"></i>

            <span>Admin</span>

        </a>

        @endif


        {{-- =========================
             TRANSAKSI
        ========================== --}}

        <div class="menu-title">
            Transaksi
        </div>


        {{-- PINJAMAN --}}

        @if(in_array($role, ['superadmin', 'admin', 'bendahara', 'pengurus']))

        <a href="{{ route('pinjaman.index') }}"
            class="{{ request()->routeIs('pinjaman.*') ? 'active' : '' }}">

            <i class="bi bi-cash-stack"></i>

            <span>Pinjaman</span>

        </a>

        @endif


        {{-- ANGSURAN --}}

        @if(in_array($role, ['superadmin', 'admin', 'bendahara', 'pengurus']))

        <a href="{{ route('angsuran.index') }}"
            class="{{ request()->routeIs('angsuran.*') ? 'active' : '' }}">

            <i class="bi bi-calendar-check"></i>

            <span>Angsuran</span>

        </a>

        @endif


        {{-- SEBRAKAN --}}

        @if(in_array($role, ['superadmin', 'admin', 'bendahara', 'pengurus']))

        <a href="{{ route('sebrakan.index') }}"
            class="{{ request()->routeIs('sebrakan.*') ? 'active' : '' }}">

            <i class="bi bi-wallet2"></i>

            <span>Sebrakan</span>

        </a>

        @endif


        {{-- =========================
             KEUANGAN
        ========================== --}}

        <div class="menu-title">
            Keuangan
        </div>


        {{-- PEMASUKAN --}}

        @if(in_array($role, ['superadmin', 'admin', 'bendahara', 'pengurus']))

        <a href="{{ route('pemasukan.index') }}"
            class="{{ request()->routeIs('pemasukan.*') ? 'active' : '' }}">

            <i class="bi bi-arrow-down-circle"></i>

            <span>Pemasukan</span>

        </a>

        @endif


        {{-- PENGELUARAN --}}

        @if(in_array($role, ['superadmin', 'admin','bendahara']))

        <a href="{{ route('pengeluaran.index') }}"
            class="{{ request()->routeIs('pengeluaran.*') ? 'active' : '' }}">

            <i class="bi bi-arrow-up-circle"></i>

            <span>Pengeluaran</span>

        </a>

        @endif


        {{-- =========================
             LAPORAN
        ========================== --}}

        @if($role === 'superadmin')

        <div class="menu-title">
            Laporan
        </div>

        <a href="#">

            <i class="bi bi-file-earmark-text"></i>

            <span>Pinjaman</span>

        </a>

        <a href="#">

            <i class="bi bi-receipt"></i>

            <span>Pembayaran</span>

        </a>

        <a href="#">

            <i class="bi bi-exclamation-triangle"></i>

            <span>Tunggakan</span>

        </a>

        @endif


        {{-- =========================
             SISTEM
        ========================== --}}

        <div class="menu-title">
            Sistem
        </div>

        <form action="{{ route('logout') }}"
            method="POST">

            @csrf

            <button
                type="submit"
                class="btn btn-link text-decoration-none text-light w-100 text-start">

                <i class="bi bi-box-arrow-right"></i>

                <span class="ms-2">
                    Logout
                </span>

            </button>

        </form>

    </div>

</div>