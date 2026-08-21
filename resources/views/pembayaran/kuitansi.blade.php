<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Kuitansi Pembayaran
    </title>

    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
        }

        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 3px 0;
            font-size: 10px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            padding: 4px;
            vertical-align: top;
        }

        .label {
            width: 120px;
            font-weight: bold;
        }

        .separator {
            width: 10px;
        }

        .payment {
            margin-top: 10px;
        }

        .payment th,
        .payment td {
            border: 1px solid #999;
            padding: 7px;
        }

        .payment th {
            background: #f2f2f2;
            text-align: center;
        }

        .payment .total {
            font-size: 14px;
            font-weight: bold;
        }

        .terbilang {
            margin-top: 12px;
            border: 1px solid #999;
            padding: 8px;
        }

        .footer {
            margin-top: 25px;
        }

        .signature {
            width: 100%;
        }

        .signature td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .space {
            height: 60px;
        }

        .small {
            font-size: 9px;
            color: #555;
        }
    </style>

</head>

<body>

    <div class="container">

        {{-- HEADER --}}

        <div class="header">

            <h1>
                APLIKASI ANGSURAN
            </h1>

            <p>
                Sistem Manajemen Pinjaman dan Angsuran
            </p>

        </div>


        {{-- JUDUL --}}

        <div class="title">

            KUITANSI PEMBAYARAN

        </div>


        {{-- INFORMASI --}}

        <table class="info">

            <tr>

                <td class="label">
                    No. Kuitansi
                </td>

                <td class="separator">
                    :
                </td>

                <td>
                    KWT-{{ str_pad(
                    $pembayaran->id_pembayaran,
                    6,
                    '0',
                    STR_PAD_LEFT
                ) }}
                </td>


                <td class="label">
                    Tanggal Bayar
                </td>

                <td class="separator">
                    :
                </td>

                <td>
                    {{ \Carbon\Carbon::parse(
                    $pembayaran->tanggal_bayar
                )->format('d-m-Y') }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Kode Anggota
                </td>

                <td class="separator">
                    :
                </td>

                <td>
                    {{ $pembayaran
                    ->angsuran
                    ->pinjaman
                    ->anggota
                    ->kode_anggota }}
                </td>


                <td class="label">
                    Nama Anggota
                </td>

                <td class="separator">
                    :
                </td>

                <td>

                    <strong>

                        {{ $pembayaran
                        ->angsuran
                        ->pinjaman
                        ->anggota
                        ->nama }}

                    </strong>

                </td>

            </tr>


            <tr>

                <td class="label">
                    No. Pinjaman
                </td>

                <td class="separator">
                    :
                </td>

                <td>

                    {{ $pembayaran
                    ->angsuran
                    ->pinjaman
                    ->no_pinjaman }}

                </td>


                <td class="label">
                    Angsuran Ke
                </td>

                <td class="separator">
                    :
                </td>

                <td>

                    {{ $pembayaran
                    ->angsuran
                    ->angsuran_ke }}

                    /

                    {{ $pembayaran
                    ->angsuran
                    ->pinjaman
                    ->tenor }}

                </td>

            </tr>


            <tr>

                <td class="label">
                    Jatuh Tempo
                </td>

                <td class="separator">
                    :
                </td>

                <td>

                    {{ \Carbon\Carbon::parse(
                    $pembayaran
                        ->angsuran
                        ->jatuh_tempo
                )->format('d-m-Y') }}

                </td>


                <td class="label">
                    Admin
                </td>

                <td class="separator">
                    :
                </td>

                <td>

                    {{ $pembayaran->admin->nama ?? '-' }}

                </td>

            </tr>

        </table>


        {{-- DETAIL PEMBAYARAN --}}

        <table class="payment">

            <thead>

                <tr>

                    <th width="50">
                        No
                    </th>

                    <th>
                        Keterangan
                    </th>

                    <th width="150">
                        Jumlah
                    </th>

                </tr>

            </thead>


            <tbody>

                <tr>

                    <td align="center">
                        1
                    </td>

                    <td>
                        Angsuran Ke-
                        {{ $pembayaran
                        ->angsuran
                        ->angsuran_ke }}
                    </td>

                    <td align="right">

                        Rp {{ number_format(
                        $pembayaran
                            ->jumlah_bayar,
                        0,
                        ',',
                        '.'
                    ) }}

                    </td>

                </tr>


                <tr>

                    <td align="center">
                        2
                    </td>

                    <td>
                        Denda
                    </td>

                    <td align="right">

                        Rp {{ number_format(
                        $pembayaran
                            ->denda,
                        0,
                        ',',
                        '.'
                    ) }}

                    </td>

                </tr>


                <tr>

                    <td
                        colspan="2"
                        align="right"
                        class="total">

                        TOTAL PEMBAYARAN

                    </td>

                    <td
                        align="right"
                        class="total">

                        Rp {{ number_format(
                        $pembayaran->jumlah_bayar
                        + $pembayaran->denda,
                        0,
                        ',',
                        '.'
                    ) }}

                    </td>

                </tr>

            </tbody>

        </table>


        {{-- KETERANGAN --}}

        @if($pembayaran->keterangan)

        <div class="terbilang">

            <strong>
                Keterangan:
            </strong>

            {{ $pembayaran->keterangan }}

        </div>

        @endif


        {{-- FOOTER --}}

        <div class="footer">

            <table class="signature">

                <tr>

                    <td>

                        <strong>
                            Anggota
                        </strong>

                        <div class="space"></div>

                        <u>

                            {{ $pembayaran
                            ->angsuran
                            ->pinjaman
                            ->anggota
                            ->nama }}

                        </u>

                    </td>


                    <td>

                        <strong>
                            Petugas
                        </strong>

                        <div class="space"></div>

                        <u>

                            {{ $pembayaran
                            ->admin
                            ->nama
                            ?? '-' }}

                        </u>

                    </td>

                </tr>

            </table>

        </div>


        <p class="small" style="text-align:center;">

            Kuitansi ini dicetak secara otomatis oleh
            Aplikasi Angsuran.

        </p>

    </div>

</body>

</html>