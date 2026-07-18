<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pembayaran;
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
        $pesanans = Pesanan::with(['meja', 'detailPesanans.produk', 'pembayaran'])
            ->whereIn('status', ['pending', 'proses'])
            ->latest()
            ->get()
            ->map(function ($pesanan) {
                
                // Normalisasi string agar seragam dibaca JavaScript
                $rawStatus = optional($pesanan->pembayaran)->status_pembayaran;
                $statusPembayaran = $rawStatus ? strtolower(trim($rawStatus)) : 'unpaid';

                return [
                    'id'                     => $pesanan->id,
                    'nomor_meja'             => $pesanan->meja->nomor_meja,
                    'tanggal_pesan'          => $pesanan->tanggal_pesan,
                    'status'                 => $pesanan->status,
                    'total_harga'            => $pesanan->total_harga,
                    'dibuat_pukul'           => $pesanan->created_at->format('H:i'),
                    'estimasi_menit'         => $pesanan->estimasiMenit,
                    'estimasi_selesai_pukul' => $pesanan->waktuEstimasiSelesai->format('H:i'),
                    'status_pembayaran'      => $statusPembayaran,
                    'tanggal_bayar'          => optional($pesanan->pembayaran)->tanggal_bayar ? \Carbon\Carbon::parse(optional($pesanan->pembayaran)->tanggal_bayar)->format('Y-m-d H:i') : null,
                    'uang_kembalian'         => optional($pesanan->pembayaran)->uang_kembalian,
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

    public function bayar(Request $request, Pesanan $pesanan)
    {
        // Tetap dipertahankan untuk backup AJAX lama jika diperlukan
        $validated = $request->validate([
            'metode' => 'required|string|max:50',
            'uang_dibayar' => 'required|numeric|min:0',
        ]);

        $total = (float) $pesanan->total_harga;
        $uangDibayar = (float) $validated['uang_dibayar'];

        if ($uangDibayar < $total) {
            return response()->json([
                'success' => false,
                'message' => 'Uang dibayar kurang dari total harga.'
            ], 422);
        }

        $uangKembalian = $uangDibayar - $total;

        $pesanan->pembayaran()->updateOrCreate(
            [],
            [
                'metode' => $validated['metode'],
                'jumlah' => $total,
                'uang_dibayar' => $uangDibayar,
                'uang_kembalian' => $uangKembalian,
                'tanggal_bayar' => now(),
                'status_pembayaran' => 'paid',
            ]
        );

        return response()->json([
            'success' => true,
            'uang_kembalian' => $uangKembalian,
        ]);
    }

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
}