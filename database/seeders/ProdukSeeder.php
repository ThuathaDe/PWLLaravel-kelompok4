<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // kategori_id => 1: Coffee, 2: Non-Coffee, 3: Snack, 4: Minuman Dingin
        DB::table('produks')->insert([
            [
                'kategori_id' => 1,
                'nama_produk' => 'Espresso',
                'harga'       => 18000,
                'deskripsi'   => 'Kopi hitam pekat dengan ekstraksi penuh, cocok untuk pecinta kopi kuat.',
                'foto_path'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kategori_id' => 1,
                'nama_produk' => 'Americano',
                'harga'       => 20000,
                'deskripsi'   => 'Espresso yang diencerkan dengan air panas, rasa ringan namun tetap nikmat.',
                'foto_path'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kategori_id' => 1,
                'nama_produk' => 'Cappuccino',
                'harga'       => 25000,
                'deskripsi'   => 'Perpaduan espresso, susu steamed, dan foam susu yang lembut.',
                'foto_path'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kategori_id' => 1,
                'nama_produk' => 'Cafe Latte',
                'harga'       => 25000,
                'deskripsi'   => 'Espresso dengan susu steamed lebih banyak, rasa lembut dan creamy.',
                'foto_path'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kategori_id' => 1,
                'nama_produk' => 'Kopi Susu Gula Aren',
                'harga'       => 22000,
                'deskripsi'   => 'Kopi susu khas nusantara dengan manis alami gula aren.',
                'foto_path'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kategori_id' => 2,
                'nama_produk' => 'Matcha Latte',
                'harga'       => 28000,
                'deskripsi'   => 'Bubuk matcha premium dipadukan dengan susu segar.',
                'foto_path'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kategori_id' => 2,
                'nama_produk' => 'Chocolate Frappe',
                'harga'       => 27000,
                'deskripsi'   => 'Minuman coklat dingin bertekstur creamy dan menyegarkan.',
                'foto_path'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kategori_id' => 4,
                'nama_produk' => 'Es Teh Manis',
                'harga'       => 10000,
                'deskripsi'   => 'Teh manis dingin klasik, cocok menemani cuaca panas.',
                'foto_path'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kategori_id' => 3,
                'nama_produk' => 'Roti Bakar Coklat',
                'harga'       => 18000,
                'deskripsi'   => 'Roti bakar dengan olesan coklat melimpah, disajikan hangat.',
                'foto_path'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kategori_id' => 3,
                'nama_produk' => 'French Fries',
                'harga'       => 20000,
                'deskripsi'   => 'Kentang goreng renyah, disajikan dengan saus pilihan.',
                'foto_path'   => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}