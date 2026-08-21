<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';

    protected $primaryKey = 'id_anggota';

    protected $fillable = [
        'kode_anggota',
        'nama',
        'nik',
        'alamat',
        'no_hp',
        'tanggal_daftar',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function pinjaman()
    {
        return $this->hasMany(
            Pinjaman::class,
            'id_anggota',
            'id_anggota'
        );
    }

    public function sebrakans(): HasMany
    {
        return $this->hasMany(
            Sebrakan::class,
            'id_anggota',
            'id_anggota'
        );
    }
}
