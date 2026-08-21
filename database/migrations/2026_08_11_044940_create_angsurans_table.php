<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('angsuran', function (Blueprint $table) {
            $table->id('id_angsuran');

            $table->foreignId('id_pinjaman')
                ->constrained('pinjaman', 'id_pinjaman')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->integer('angsuran_ke');

            $table->date('jatuh_tempo');

            $table->decimal('jumlah_angsuran', 15, 2);

            $table->decimal('jumlah_dibayar', 15, 2)
                ->default(0);

            $table->decimal('denda', 15, 2)
                ->default(0);

            $table->enum('status', [
                'belum_bayar',
                'sebagian',
                'lunas',
                'terlambat'
            ])->default('belum_bayar');

            $table->date('tanggal_lunas')->nullable();

            $table->timestamps();

            $table->unique([
                'id_pinjaman',
                'angsuran_ke'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsurans');
    }
};
