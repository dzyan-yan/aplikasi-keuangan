<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sebrakans', function (Blueprint $table) {

            $table->id('id_sebrakan');

            // Relasi ke anggota
            $table->unsignedBigInteger('id_anggota');

            // Tanggal transaksi
            $table->date('tanggal_sebrakan');
            $table->date('tanggal_jatuh_tempo');

            // Nilai sebrakan
            $table->decimal('pokok', 15, 2);
            $table->decimal('bunga_persen', 5, 2)->default(5.00);
            $table->decimal('bunga', 15, 2);
            $table->decimal('total', 15, 2);

            // Pembayaran
            $table->decimal('jumlah_bayar', 15, 2)->default(0);
            $table->date('tanggal_bayar')->nullable();

            // Status
            $table->enum('status', [
                'belum_lunas',
                'lunas',
                'terlambat'
            ])->default('belum_lunas');

            $table->timestamps();

            // Foreign key
            $table->foreign('id_anggota')
                ->references('id_anggota')
                ->on('anggotas')
                ->restrictOnDelete();

            // Index
            $table->index('tanggal_sebrakan');
            $table->index('tanggal_jatuh_tempo');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sebrakans');
    }
};
