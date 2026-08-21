@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">
            Dashboard
        </h3>

        <p class="text-muted mb-0">
            Ringkasan kondisi keuangan dan kegiatan organisasi.
        </p>
    </div>

    <div>
        <span class="badge bg-primary px-3 py-2">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->translatedFormat('d F Y') }}
        </span>
    </div>

</div>


{{-- ========================================================= --}}
{{-- RINGKASAN UTAMA --}}
{{-- ========================================================= --}}

<div class="row g-3 mb-4">

    {{-- SALDO --}}
    <div class="col-md-6 col-xl-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>
                        <small class="text-muted">
                            Saldo Kas
                        </small>

                        <h4 class="fw-bold mt-2 mb-0
                            {{ ($saldo ?? 0) >= 0
                                ? 'text-success'
                                : 'text-danger' }}">

                            Rp {{ number_format(
                                $saldo ?? 0,
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


    {{-- TOTAL PEMASUKAN --}}
    <div class="col-md-6 col-xl-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Total Pemasukan
                        </small>

                        <h4 class="fw-bold mt-2 mb-0 text-success">

                            Rp {{ number_format(
                                $totalPemasukan ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

                        </h4>

                    </div>

                    <div class="text-success fs-2">

                        <i class="bi bi-arrow-down-circle"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TOTAL PENGELUARAN --}}
    <div class="col-md-6 col-xl-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Total Pengeluaran
                        </small>

                        <h4 class="fw-bold mt-2 mb-0 text-danger">

                            Rp {{ number_format(
                                $totalPengeluaran ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}

                        </h4>

                    </div>

                    <div class="text-danger fs-2">

                        <i class="bi bi-arrow-up-circle"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ANGSURAN --}}
    <div class="col-md-6 col-xl-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Total Angsuran
                        </small>

                        <h4 class="fw-bold mt-2 mb-0 text-primary">

                            Rp {{ number_format(
                                $totalAngsuran ?? 0,
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

</div>


{{-- ========================================================= --}}
{{-- RINGKASAN BULAN INI --}}
{{-- ========================================================= --}}

<div class="row g-3 mb-4">

    {{-- PEMASUKAN BULAN INI --}}
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">
                    Pemasukan Bulan Ini
                </small>

                <h4 class="fw-bold text-success mt-2">

                    Rp {{ number_format(
                        $pemasukanBulanIni ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

                </h4>

            </div>

        </div>

    </div>


    {{-- PENGELUARAN BULAN INI --}}
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">
                    Pengeluaran Bulan Ini
                </small>

                <h4 class="fw-bold text-danger mt-2">

                    Rp {{ number_format(
                        $pengeluaranBulanIni ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

                </h4>

            </div>

        </div>

    </div>


    {{-- SURPLUS --}}
    <div class="col-md-4">

        @php
        $surplusBulanIni =
        ($pemasukanBulanIni ?? 0)
        -
        ($pengeluaranBulanIni ?? 0);
        @endphp

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">
                    Surplus / Defisit Bulan Ini
                </small>

                <h4 class="fw-bold mt-2
                    {{ $surplusBulanIni >= 0
                        ? 'text-success'
                        : 'text-danger' }}">

                    Rp {{ number_format(
                        $surplusBulanIni,
                        0,
                        ',',
                        '.'
                    ) }}

                </h4>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- STATISTIK ORGANISASI --}}
{{-- ========================================================= --}}

<div class="row g-3 mb-4">

    {{-- ANGGOTA --}}
    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">
                    Total Anggota
                </small>

                <h3 class="fw-bold mb-0">

                    {{ $totalAnggota ?? 0 }}

                </h3>

            </div>

        </div>

    </div>


    {{-- ANGGOTA AKTIF --}}
    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">
                    Anggota Aktif
                </small>

                <h3 class="fw-bold text-success mb-0">

                    {{ $anggotaAktif ?? 0 }}

                </h3>

            </div>

        </div>

    </div>


    {{-- PINJAMAN AKTIF --}}
    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">
                    Pinjaman Aktif
                </small>

                <h3 class="fw-bold text-primary mb-0">

                    {{ $pinjamanAktif ?? 0 }}

                </h3>

            </div>

        </div>

    </div>


    {{-- ANGSURAN BELUM LUNAS --}}
    <div class="col-md-3">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">
                    Angsuran Belum Lunas
                </small>

                <h3 class="fw-bold text-warning mb-0">

                    {{ $angsuranBelumLunas ?? 0 }}

                </h3>

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- GRAFIK KEUANGAN --}}
{{-- ========================================================= --}}

<div class="row g-4 mb-4">

    {{-- ===================================================== --}}
    {{-- ARUS KAS --}}
    {{-- ===================================================== --}}

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white py-3">

                <strong>

                    <i class="bi bi-bar-chart me-2"></i>

                    Arus Kas

                </strong>

            </div>

            <div class="card-body">

                <div style="height: 320px;">

                    <canvas id="chartArusKas"></canvas>

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- KOMPOSISI KEUANGAN --}}
    {{-- ===================================================== --}}

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white py-3">

                <strong>

                    <i class="bi bi-pie-chart me-2"></i>

                    Komposisi Keuangan

                </strong>

            </div>

            <div class="card-body">

                <div style="height: 320px;">

                    <canvas id="chartKomposisi"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- TRANSAKSI TERBARU --}}
{{-- ========================================================= --}}

<div class="row g-4">

    {{-- PEMASUKAN TERBARU --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between">

                    <strong>
                        <i class="bi bi-arrow-down-circle text-success me-2"></i>
                        Pemasukan Terbaru
                    </strong>

                    <a
                        href="{{ route('pemasukan.index') }}"
                        class="btn btn-sm btn-outline-primary">

                        Lihat Semua

                    </a>

                </div>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>Tanggal</th>

                                <th>Kategori</th>

                                <th>Sumber</th>

                                <th class="text-end">
                                    Jumlah
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($pemasukanTerbaru ?? [] as $pemasukan)

                            <tr>

                                <td>

                                    {{ \Carbon\Carbon::parse(
                                        $pemasukan->tanggal
                                    )->format('d-m-Y') }}

                                </td>

                                <td>

                                    <span class="badge bg-success">

                                        {{ $pemasukan->kategori }}

                                    </span>

                                </td>

                                <td>

                                    {{ $pemasukan->sumber ?? '-' }}

                                </td>

                                <td class="text-end fw-bold text-success">

                                    Rp {{ number_format(
                                        $pemasukan->jumlah,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center text-muted py-4">

                                    Belum ada transaksi pemasukan.

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- PENGELUARAN TERBARU --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between">

                    <strong>

                        <i class="bi bi-arrow-up-circle text-danger me-2"></i>

                        Pengeluaran Terbaru

                    </strong>

                    <a
                        href="{{ route('pengeluaran.index') }}"
                        class="btn btn-sm btn-outline-primary">

                        Lihat Semua

                    </a>

                </div>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>Tanggal</th>

                                <th>Kategori</th>

                                <th>Keperluan</th>

                                <th class="text-end">
                                    Jumlah
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($pengeluaranTerbaru ?? [] as $pengeluaran)

                            <tr>

                                <td>

                                    {{ \Carbon\Carbon::parse(
                                        $pengeluaran->tanggal
                                    )->format('d-m-Y') }}

                                </td>

                                <td>

                                    <span class="badge bg-danger">

                                        {{ $pengeluaran->kategori }}

                                    </span>

                                </td>

                                <td>

                                    {{ $pengeluaran->keperluan ?? '-' }}

                                </td>

                                <td class="text-end fw-bold text-danger">

                                    Rp {{ number_format(
                                        $pengeluaran->jumlah,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center text-muted py-4">

                                    Belum ada transaksi pengeluaran.

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ========================================================= --}}
{{-- CHART.JS --}}
{{-- ========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK
        |--------------------------------------------------------------------------
        */

        const labels = @json($bulanLabels ?? []);

        const pemasukanData = @json($grafikPemasukan ?? []);

        const pengeluaranData = @json($grafikPengeluaran ?? []);


        /*
        |--------------------------------------------------------------------------
        | FORMAT RUPIAH
        |--------------------------------------------------------------------------
        */

        function formatRupiah(value) {

            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);

        }


        /*
        |--------------------------------------------------------------------------
        | GRAFIK ARUS KAS
        |--------------------------------------------------------------------------
        */

        const canvasArusKas =
            document.getElementById('chartArusKas');


        if (canvasArusKas) {

            new Chart(canvasArusKas, {

                type: 'bar',

                data: {

                    labels: labels,

                    datasets: [

                        {

                            label: 'Pemasukan',

                            data: pemasukanData,

                            borderWidth: 1

                        },

                        {

                            label: 'Pengeluaran',

                            data: pengeluaranData,

                            borderWidth: 1

                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    interaction: {

                        mode: 'index',

                        intersect: false

                    },

                    scales: {

                        y: {

                            beginAtZero: true,

                            ticks: {

                                callback: function(value) {

                                    return formatRupiah(value);

                                }

                            }

                        }

                    },

                    plugins: {

                        legend: {

                            position: 'top'

                        },

                        tooltip: {

                            callbacks: {

                                label: function(context) {

                                    return context.dataset.label +
                                        ': ' +
                                        formatRupiah(context.raw);

                                }

                            }

                        }

                    }

                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | GRAFIK KOMPOSISI KEUANGAN
        |--------------------------------------------------------------------------
        */

        const canvasKomposisi =
            document.getElementById('chartKomposisi');


        if (canvasKomposisi) {

            new Chart(canvasKomposisi, {

                type: 'doughnut',

                data: {

                    labels: [

                        'Pemasukan',

                        'Pengeluaran'

                    ],

                    datasets: [

                        {

                            data: @json([
                                $totalPemasukan ?? 0,
                                $totalPengeluaran ?? 0
                            ]),

                            borderWidth: 1

                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {

                            position: 'bottom'

                        },

                        tooltip: {

                            callbacks: {

                                label: function(context) {

                                    return context.label +
                                        ': ' +
                                        formatRupiah(context.raw);

                                }

                            }

                        }

                    }

                }

            });

        }

    });
</script>

@endsection