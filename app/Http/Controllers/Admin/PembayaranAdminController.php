<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranAdminController extends Controller
{
    public function show(Pesanan $pesanan)
    {
        if (optional($pesanan->pembayaran)->status_pembayaran === 'paid') {
            return redirect()->route('admin.dashboard')->with('error', 'Pesanan ini sudah lunas.');
        }

        $detailPesanans = $pesanan->detailPesanans()->with('produk')->get();
        return view('admin.pesanan.bayar', compact('pesanan', 'detailPesanans'));
    }

    public function submit(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'uang_dibayar' => 'required|numeric|min:' . $pesanan->total_harga,
        ], [
            'uang_dibayar.min' => 'Uang yang dimasukkan kurang dari total tagihan!',
        ]);

        $uangDibayar = $request->uang_dibayar;
        $kembalian = $uangDibayar - $pesanan->total_harga;

        DB::transaction(function () use ($pesanan, $uangDibayar, $kembalian) {
            // Memperbarui status pembayaran ke model relasi 'pembayaran'
            $pesanan->pembayaran()->updateOrCreate(
                [],
                [
                    'metode' => 'cash',
                    'jumlah' => $pesanan->total_harga,
                    'uang_dibayar' => $uangDibayar,
                    'uang_kembalian' => $kembalian,
                    'tanggal_bayar' => now(),
                    'status_pembayaran' => 'paid', // Mengunci string 'paid'
                ]
            );
        });

        return redirect()->route('admin.dashboard')->with('success', 'Pembayaran Berhasil! Status Pembayaran Kini PAID.');
    }
}