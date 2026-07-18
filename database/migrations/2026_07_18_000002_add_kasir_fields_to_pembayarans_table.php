<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->decimal('uang_dibayar', 10, 2)->default(0)->after('jumlah');
            $table->decimal('uang_kembalian', 10, 2)->default(0)->after('uang_dibayar');
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn(['uang_kembalian', 'uang_dibayar']);
        });
    }
};

