<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengeluarans', function (Blueprint $table) {

            $table->id('id_pengeluaran');

            $table->date('tanggal');

            $table->string('kategori', 100);

            $table->string('keperluan', 150)->nullable();

            $table->string('keterangan', 255)->nullable();

            $table->decimal('jumlah', 15, 2);

            $table->unsignedBigInteger('id_admin');

            $table->timestamps();

            // Relasi ke admin
            $table->foreign('id_admin')
                ->references('id_admin')
                ->on('admins')
                ->onUpdate('cascade');

            // Index
            $table->index('tanggal');
            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
