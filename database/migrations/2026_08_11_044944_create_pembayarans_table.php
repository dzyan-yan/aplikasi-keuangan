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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');

            $table->foreignId('id_angsuran')
                ->constrained('angsuran', 'id_angsuran')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->date('tanggal_bayar');

            $table->decimal('jumlah_bayar', 15, 2);

            $table->decimal('denda', 15, 2)
                ->default(0);

            $table->string('keterangan')->nullable();

            $table->foreignId('id_admin')
                ->constrained('admins', 'id_admin')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
