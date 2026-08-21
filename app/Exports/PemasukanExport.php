<?php

namespace App\Exports;

use App\Models\Pemasukan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PemasukanExport implements FromCollection, WithHeadings
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
        $query = Pemasukan::with('admin')
            ->orderBy('tanggal')
            ->orderBy('id_pemasukan');

        if ($this->bulan) {
            $query->whereMonth(
                'tanggal',
                $this->bulan
            );
        }

        if ($this->tahun) {
            $query->whereYear(
                'tanggal',
                $this->tahun
            );
        }

        return $query->get()->map(function ($pemasukan) {

            return [
                $pemasukan->tanggal,
                $pemasukan->kategori,
                $pemasukan->sumber,
                $pemasukan->keterangan,
                $pemasukan->jumlah,
                $pemasukan->referensi_type,
                $pemasukan->referensi_id,
                optional($pemasukan->admin)->nama,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kategori',
            'Sumber',
            'Keterangan',
            'Jumlah',
            'Referensi Type',
            'Referensi ID',
            'Admin',
        ];
    }
}
