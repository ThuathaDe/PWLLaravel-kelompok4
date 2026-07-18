<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pesanans')->insert([
            [
                'meja_id' => 1,
                'tanggal_pesan' => date('Y-m-d'),
                'status' => 'selesai',
                'total_harga' => 63000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'meja_id' => 5,
                'tanggal_pesan' => date('Y-m-d'),
                'status' => 'proses',
                'total_harga' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'meja_id' => 6,
                'tanggal_pesan' => date('Y-m-d'),
                'status' => 'selesai',
                'total_harga' => 90000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'meja_id' => 3,
                'tanggal_pesan' => date('Y-m-d'),
                'status' => 'pending',
                'total_harga' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'meja_id' => 7,
                'tanggal_pesan' => date('Y-m-d'),
                'status' => 'selesai',
                'total_harga' => 38000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

