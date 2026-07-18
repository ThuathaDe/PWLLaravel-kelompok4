@extends('layouts.app')

@section('title', 'Riwayat Pesanan')
@section('nav-info', 'Riwayat Pesanan')

@section('content')
    <p class="font-mono-label text-xs mb-1" style="color: var(--mustard-dark);">PEMBUKUAN</p>
    <h1 class="font-marker text-2xl mb-6">Riwayat Pesanan Selesai</h1>

    <form method="GET" class="flex items-center gap-3 mb-6">
        <label class="text-sm font-medium">Tanggal:</label>
        <input type="date" name="tanggal" value="{{ $tanggal }}"
               class="border rounded px-3 py-2" style="border-color: var(--paper-line);"
               onchange="this.form.submit()">
    </form>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="card-paper p-4">
            <p class="font-mono-label text-xs mb-1" style="color: var(--ink-soft);">TOTAL PESANAN</p>
            <p class="font-marker text-2xl">{{ $totalPesanan }}</p>
        </div>
        <div class="card-paper p-4">
            <p class="font-mono-label text-xs mb-1" style="color: var(--ink-soft);">TOTAL PENDAPATAN</p>
            <p class="font-marker text-2xl" style="color: var(--clay);">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="card-paper overflow-hidden">
        <table class="w-full text-left">
            <thead style="background: var(--paper); border-bottom: 1px solid var(--paper-line);">
                <tr>
                    <th class="px-4 py-3 font-mono-label text-xs" style="color: var(--ink-soft);">JAM SELESAI</th>
                    <th class="px-4 py-3 font-mono-label text-xs" style="color: var(--ink-soft);">MEJA</th>
                    <th class="px-4 py-3 font-mono-label text-xs" style="color: var(--ink-soft);">ITEM</th>
                    <th class="px-4 py-3 font-mono-label text-xs" style="color: var(--ink-soft);">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanans as $pesanan)
                    <tr style="border-bottom: 1px solid var(--paper-line);">
                        <td class="px-4 py-3">{{ $pesanan->updated_at->format('H:i') }}</td>
                        <td class="px-4 py-3">Meja {{ $pesanan->meja->nomor_meja }}</td>
                        <td class="px-4 py-3 text-sm" style="color: var(--ink-soft);">
                            @foreach ($pesanan->detailPesanans as $detail)
                                {{ $detail->produk->nama_produk }} x{{ $detail->jumlah }}@if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td class="px-4 py-3 font-semibold">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center" style="color: var(--ink-soft);">
                            Belum ada pesanan selesai pada tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <br>
    <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-semibold text-sm">← Kembali ke dashboard</a>
@endsection