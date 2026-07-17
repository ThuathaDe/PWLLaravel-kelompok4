<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meja_id')->constrained('mejas')->cascadeOnDelete();
            $table->date('tanggal_pesan');
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};