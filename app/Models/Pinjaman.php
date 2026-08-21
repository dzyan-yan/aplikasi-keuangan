<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    protected $primaryKey = 'id_pinjaman';

    protected $fillable = [
        'no_pinjaman',
        'id_anggota',
        'tanggal_pinjaman',
        'jumlah_pinjaman',
        'bunga_persen',
        'jumlah_bunga',
        'total_pinjaman',
        'tenor',
        'periode_hari',
        'jumlah_angsuran',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjaman' => 'date',
        'jumlah_pinjaman' => 'decimal:2',
        'bunga_persen' => 'decimal:2',
        'jumlah_bunga' => 'decimal:2',
        'total_pinjaman' => 'decimal:2',
        'jumlah_angsuran' => 'decimal:2',
    ];

    public function anggota()
    {
        return $this->belongsTo(
            Anggota::class,
            'id_anggota',
            'id_anggota'
        );
    }

    public function angsuran()
    {
        return $this->hasMany(
            Angsuran::class,
            'id_pinjaman',
            'id_pinjaman'
        );
    }
}
