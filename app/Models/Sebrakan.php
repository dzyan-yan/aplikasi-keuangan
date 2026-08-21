<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sebrakan extends Model
{
    protected $table = 'sebrakans';

    protected $primaryKey = 'id_sebrakan';

    protected $fillable = [
        'id_anggota',
        'tanggal_sebrakan',
        'tanggal_jatuh_tempo',
        'pokok',
        'bunga_persen',
        'bunga',
        'total',
        'jumlah_bayar',
        'tanggal_bayar',
        'status',
    ];

    protected $casts = [
        'tanggal_sebrakan'    => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_bayar'       => 'date',
        'pokok'               => 'decimal:2',
        'bunga_persen'        => 'decimal:2',
        'bunga'               => 'decimal:2',
        'total'               => 'decimal:2',
        'jumlah_bayar'        => 'decimal:2',
    ];

    /**
     * Sebrakan milik anggota.
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(
            Anggota::class,
            'id_anggota',
            'id_anggota'
        );
    }
}
