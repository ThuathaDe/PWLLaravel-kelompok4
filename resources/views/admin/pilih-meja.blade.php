@extends('layouts.app')

@section('title', 'Buat Pesanan')
@section('nav-info', 'Buat Pesanan untuk Pelanggan')

@section('content')
    <p class="font-mono-label text-xs mb-1" style="color: var(--mustard-dark);">LAYANI PELANGGAN</p>
    <h1 class="font-marker text-2xl mb-6">Pilih Meja</h1>

    <div class="grid grid-cols-3 md:grid-cols-5 gap-3">
        @forelse ($mejas as $meja)
            @if ($meja->pesanan_aktif_count > 0)
                <div class="p-4 text-center font-semibold rounded cursor-not-allowed"
                     style="background: #e8e2d2; border: 1px solid var(--paper-line); color: var(--ink-soft); opacity: 0.6;">
                    Meja {{ $meja->nomor_meja }}
                    <div class="font-mono-label text-xs mt-1" style="color: var(--clay-dark);">TERISI</div>
                </div>
            @else
                <a href="{{ route('pemesanan.index', $meja->nomor_meja) }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded">
                    Meja {{ $meja->nomor_meja }}
                    <div class="font-mono-label text-xs mt-1" style="color: #ffff;">KOSONG</div>
                </a>
            @endif
        @empty
            <p style="color: var(--ink-soft);">Belum ada data meja.</p>
        @endforelse
    </div>
    <br><br>
    <a href="{{ route('admin.dashboard') }}" class="bg-green-500 text-white px-4 py-2 rounded">← Kembali ke dashboard</a>
@endsection