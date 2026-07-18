<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Tampilkan halaman dashboard (layout + content)
    public function index()
    {
        return view('admin.dashboard');
    }

    // Endpoint JSON yang dipanggil berulang oleh JavaScript (polling) untuk data real-time
    public function data()
    {
        $pesanans = Pesanan::with(['meja', 'detailPesanans.produk'])
            ->whereIn('status', ['pending', 'proses'])
            ->latest()
            ->get()
            ->map(function ($pesanan) {
                return [
                    'id'                     => $pesanan->id,
                    'nomor_meja'             => $pesanan->meja->nomor_meja,
                    'tanggal_pesan'          => $pesanan->tanggal_pesan,
                    'status'                 => $pesanan->status,
                    'total_harga'            => $pesanan->total_harga,
                    'dibuat_pukul'           => $pesanan->created_at->format('H:i'),
                    'estimasi_menit'         => $pesanan->estimasiMenit,
                    'estimasi_selesai_pukul' => $pesanan->waktuEstimasiSelesai->format('H:i'),
                    'items'                  => $pesanan->detailPesanans->map(function ($detail) {
                        return [
                            'nama_produk' => $detail->produk->nama_produk,
                            'jumlah'      => $detail->jumlah,
                        ];
                    }),
                ];
            });

        return response()->json($pesanans);
    }

    // Ubah status pesanan (dipanggil dari tombol di dashboard via AJAX)
    public function ubahStatus(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $pesanan->update([
            'status' => $validated['status']
        ]);

        return response()->json(['success' => true]);
    }

    // Tampilkan daftar meja untuk admin, supaya admin bisa buatkan pesanan langsung
    // Tampilkan daftar meja untuk admin, supaya admin bisa buatkan pesanan langsung
    public function buatPesanan()
    {
        $mejas = \App\Models\Meja::withCount([
                'pesanans as pesanan_aktif_count' => function ($query) {
                    $query->whereIn('status', ['pending', 'proses']);
                }
            ])
            ->orderBy('nomor_meja')
            ->get();

        return view('admin.pilih-meja', compact('mejas'));
    }

    // Tampilkan menu untuk 1 meja tertentu, versi tampilan admin (bukan tampilan pelanggan)
    public function menuMeja(string $nomorMeja)
    {
        $meja = \App\Models\Meja::where('nomor_meja', $nomorMeja)->firstOrFail();
        $kategoris = \App\Models\Kategori::with('produks')->get();

        return view('admin.pesanan-menu', compact('meja', 'kategoris'));
    }
}