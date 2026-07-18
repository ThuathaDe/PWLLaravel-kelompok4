<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->cascadeOnDelete();

            $table->string('metode')->default('cash');
            $table->decimal('jumlah', 10, 2)->default(0);
            $table->dateTime('tanggal_bayar')->nullable();

            $table->enum('status_pembayaran', ['unpaid', 'paid', 'failed'])->default('unpaid');

            $table->timestamps();

            $table->unique('pesanan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};

