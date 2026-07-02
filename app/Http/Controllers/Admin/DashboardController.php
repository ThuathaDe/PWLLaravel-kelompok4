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
                    'id'          => $pesanan->id,
                    'nomor_meja'  => $pesanan->meja->nomor_meja,
                    'status'      => $pesanan->status,
                    'total_harga' => $pesanan->total_harga,
                    'items'       => $pesanan->detailPesanans->map(function ($detail) {
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

        $pesanan->update(['status' => $validated['status']]);

        return response()->json(['success' => true]);
    }
}
