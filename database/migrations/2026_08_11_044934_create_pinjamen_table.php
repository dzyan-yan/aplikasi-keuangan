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
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id('id_pinjaman');

            $table->string('no_pinjaman', 30)->unique();

            $table->foreignId('id_anggota')
                ->constrained('anggotas', 'id_anggota')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->date('tanggal_pinjaman');

            $table->decimal('jumlah_pinjaman', 15, 2);

            $table->decimal('bunga_persen', 5, 2)
                ->default(20);

            $table->decimal('jumlah_bunga', 15, 2)
                ->default(0);

            $table->decimal('total_pinjaman', 15, 2)
                ->default(0);

            $table->integer('tenor')->default(12);

            $table->integer('periode_hari')->default(35);

            $table->decimal('jumlah_angsuran', 15, 2)
                ->default(0);

            $table->enum('status', [
                'aktif',
                'lunas',
                'dibatalkan'
            ])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamen');
    }
};
