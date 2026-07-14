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
        // meja_id mengacu ke tabel mejas (1: A1, 2: A2, 3: A3, 4: B1, 5: B2, 6: V1, 7: S1)
        DB::table('pesanans')->insert([
            [
                'meja_id'     => 1,
                'status'      => 'selesai',
                'total_harga' => 63000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'meja_id'     => 5,
                'status'      => 'proses',
                'total_harga' => 45000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'meja_id'     => 6,
                'status'      => 'selesai',
                'total_harga' => 90000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'meja_id'     => 3,
                'status'      => 'pending',
                'total_harga' => 30000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'meja_id'     => 7,
                'status'      => 'selesai',
                'total_harga' => 38000,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}