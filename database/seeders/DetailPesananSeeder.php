<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_pesanans')->insert([
            // Pesanan 1 (meja A1) - Espresso + Cappuccino + Roti Bakar
            [
                'pesanan_id' => 1,
                'produk_id'  => 1,
                'jumlah'     => 1,
                'subtotal'   => 18000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 1,
                'produk_id'  => 3,
                'jumlah'     => 1,
                'subtotal'   => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 1,
                'produk_id'  => 9,
                'jumlah'     => 1,
                'subtotal'   => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Pesanan 2 (meja B2) - Cafe Latte + Es Teh Manis
            [
                'pesanan_id' => 2,
                'produk_id'  => 4,
                'jumlah'     => 1,
                'subtotal'   => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 2,
                'produk_id'  => 8,
                'jumlah'     => 2,
                'subtotal'   => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Pesanan 3 (meja V1) - Matcha Latte + Chocolate Frappe + French Fries
            [
                'pesanan_id' => 3,
                'produk_id'  => 6,
                'jumlah'     => 1,
                'subtotal'   => 28000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 3,
                'produk_id'  => 7,
                'jumlah'     => 1,
                'subtotal'   => 27000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 3,
                'produk_id'  => 10,
                'jumlah'     => 1,
                'subtotal'   => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Pesanan 4 (meja A3) - Kopi Susu Gula Aren + Es Teh Manis
            [
                'pesanan_id' => 4,
                'produk_id'  => 5,
                'jumlah'     => 1,
                'subtotal'   => 22000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 4,
                'produk_id'  => 8,
                'jumlah'     => 1,
                'subtotal'   => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Pesanan 5 (meja S1) - Americano + Roti Bakar
            [
                'pesanan_id' => 5,
                'produk_id'  => 2,
                'jumlah'     => 1,
                'subtotal'   => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 5,
                'produk_id'  => 9,
                'jumlah'     => 1,
                'subtotal'   => 18000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}