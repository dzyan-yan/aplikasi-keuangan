<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pinjaman;
use App\Models\Pembayaran;

class Angsuran extends Model
{
    protected $table = 'angsuran';

    protected $primaryKey = 'id_angsuran';

    protected $fillable = [
        'id_pinjaman',
        'angsuran_ke',
        'jatuh_tempo',
        'jumlah_angsuran',
        'jumlah_dibayar',
        'denda',
        'status',
        'tanggal_lunas',
    ];

    protected $casts = [
        'jatuh_tempo' => 'date',
        'tanggal_lunas' => 'date',
        'jumlah_angsuran' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'denda' => 'decimal:2',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(
            Pinjaman::class,
            'id_pinjaman',
            'id_pinjaman'
        );
    }

    public function pembayarans()
    {
        return $this->hasMany(
            Pembayaran::class,
            'id_angsuran',
            'id_angsuran'
        );
    }
}
