<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_angsuran',
        'tanggal_bayar',
        'jumlah_bayar',
        'denda',
        'keterangan',
        'id_admin',
    ];

    public function angsuran()
    {
        return $this->belongsTo(
            Angsuran::class,
            'id_angsuran',
            'id_angsuran'
        );
    }

    public function admin()
    {
        return $this->belongsTo(
            Admin::class,
            'id_admin',
            'id_admin'
        );
    }
}
