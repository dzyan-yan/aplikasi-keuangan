<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemasukan extends Model
{
    protected $table = 'pemasukans';

    protected $primaryKey = 'id_pemasukan';

    protected $fillable = [
        'tanggal',
        'kategori',
        'sumber',
        'keterangan',
        'jumlah',
        'referensi_type',
        'referensi_id',
        'id_admin',
    ];


    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    /**
     * Admin yang mencatat pemasukan
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(
            Admin::class,
            'id_admin',
            'id_admin'
        );
    }
}
