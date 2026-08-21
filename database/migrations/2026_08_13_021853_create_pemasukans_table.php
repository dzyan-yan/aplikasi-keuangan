<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemasukans', function (Blueprint $table) {

            $table->id('id_pemasukan');

            $table->date('tanggal');

            $table->string('kategori', 100);

            $table->string('sumber', 150)->nullable();

            $table->string('keterangan')->nullable();

            $table->decimal('jumlah', 15, 2);

            // Referensi transaksi otomatis
            $table->string('referensi_type', 50)->nullable();

            $table->unsignedBigInteger('referensi_id')->nullable();

            // Admin yang mencatat
            $table->unsignedBigInteger('id_admin');

            $table->timestamps();

            $table->foreign('id_admin')
                ->references('id_admin')
                ->on('admins')
                ->onUpdate('cascade');

            $table->index([
                'referensi_type',
                'referensi_id'
            ]);

            $table->index('tanggal');
            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};
