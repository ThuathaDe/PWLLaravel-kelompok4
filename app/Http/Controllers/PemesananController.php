<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Kategori;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    // Tampilkan katalog menu (diakses via QR Code di meja)
    public function index(string $nomorMeja)
    {
        $meja = Meja::where('nomor_meja', $nomorMeja)->firstOrFail();
        $kategoris = Kategori::with('produks')->get();

        return view('pemesanan.index', compact('meja', 'kategoris'));
    }

    // Simpan pesanan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'meja_id'           => 'required|exists:mejas,id',
            'items'             => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.jumlah'    => 'required|integer|min:1',
        ]);

        $pesanan = DB::transaction(function () use ($validated) {


            $pesanan = Pesanan::create([
                'meja_id'        => $validated['meja_id'],
                'tanggal_pesan'  => now(), // otomatis mengisi tanggal & jam saat pesan
                'status'         => 'pending',
                'total_harga'    => 0,
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $produkId = $item['produk_id'];
                $jumlah   = $item['jumlah'];

                $produk   = Produk::findOrFail($produkId);

                $subtotal = $produk->harga * $jumlah;

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id'  => $produk->id,
                    'jumlah'     => $jumlah,
                    'subtotal'   => $subtotal,
                ]);

                $total += $subtotal;
            }

            $pesanan->update([
                'total_harga' => $total,
            ]);

            return $pesanan;
        });

        if (session('is_admin')) {
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Pesanan untuk Meja ' . $pesanan->meja->nomor_meja . ' berhasil dibuat.');
        }

        return redirect()
            ->route('pemesanan.selesai', $pesanan->id)
            ->with('success', 'Pesanan berhasil dikirim!');
            }

    public function selesai(Pesanan $pesanan)
    {
        return view('pemesanan.selesai', compact('pesanan'));
    }
}