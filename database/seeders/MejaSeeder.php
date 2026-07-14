<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mejas')->insert([
            [
                'nomor_meja' => '01',
                'status'     => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_meja' => '02',
                'status'     => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_meja' => '03',
                'status'     => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_meja' => '04',
                'status'     => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_meja' => '05',
                'status'     => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_meja' => '06',
                'status'     => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_meja' => '07',
                'status'     => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}