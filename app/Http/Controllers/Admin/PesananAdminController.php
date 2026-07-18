<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananAdminController extends Controller
{
    public function edit(Pesanan $pesanan)
    {
        if (!in_array($pesanan->status, ['pending', 'proses'])) {
            abort(403, 'Pesanan tidak bisa diedit');
        }

        $mejas = Meja::orderBy('nomor_meja')->get();
        $produks = Produk::orderBy('kategori_id')->get();

        $detailPesanans = $pesanan->detailPesanans()->with('produk')->get();

        return view('admin.pesanan.edit', compact('pesanan', 'mejas', 'produks', 'detailPesanans'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        if (!in_array($pesanan->status, ['pending', 'proses'])) {
            abort(403, 'Pesanan tidak bisa diedit');
        }

        $validated = $request->validate([
            'meja_id' => 'required|exists:mejas,id',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($pesanan, $validated) {
            // update meja
            $pesanan->update([
                'meja_id' => $validated['meja_id'],
            ]);

            // rebuild detail
            DetailPesanan::where('pesanan_id', $pesanan->id)->delete();

            $total = 0;
            foreach ($validated['items'] as $item) {
                $produk = \App\Models\Produk::findOrFail($item['produk_id']);
                $subtotal = $produk->harga * $item['jumlah'];

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $produk->id,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $pesanan->update(['total_harga' => $total]);

            // Jika sudah paid, sistem tetap lunas (sesuai aturan bisnis yang tidak dibahas detail).
            // Namun harga total berubah, jadi kita sync pembayaran (jumlah) agar konsisten.
            if ($pesanan->pembayaran) {
                $pesanan->pembayaran->update([
                    'jumlah' => $total,
                    'uang_dibayar' => $pesanan->pembayaran->uang_dibayar ?? $total,
                    'uang_kembalian' => max(0, ($pesanan->pembayaran->uang_dibayar ?? $total) - $total),
                ]);
            }
        });

        return redirect()->route('admin.dashboard')->with('success', 'Pesanan berhasil diperbarui');
    }
}

