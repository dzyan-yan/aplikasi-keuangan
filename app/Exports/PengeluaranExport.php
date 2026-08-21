<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengeluaranExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection(): Collection
    {
        $query = Pengeluaran::with('admin')
            ->orderBy('tanggal')
            ->orderBy('id_pengeluaran');

        if ($this->bulan) {
            $query->whereMonth('tanggal', $this->bulan);
        }

        if ($this->tahun) {
            $query->whereYear('tanggal', $this->tahun);
        }

        return $query->get()->map(function ($pengeluaran) {

            return [
                'Tanggal'     => $pengeluaran->tanggal,
                'Kategori'    => $pengeluaran->kategori,
                'Keperluan'   => $pengeluaran->keperluan,
                'Keterangan'  => $pengeluaran->keterangan,
                'Jumlah'      => $pengeluaran->jumlah,
                'Admin'       => $pengeluaran->admin->nama ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kategori',
            'Keperluan',
            'Keterangan',
            'Jumlah',
            'Admin',
        ];
    }
}
