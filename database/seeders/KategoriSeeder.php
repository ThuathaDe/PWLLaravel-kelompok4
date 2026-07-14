<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategoris')->insert([
            [
                'nama_kategori' => 'Coffee',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_kategori' => 'Non-Coffee',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_kategori' => 'Snack',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_kategori' => 'Minuman Dingin',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}