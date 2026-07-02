@extends('layouts.app')

@section('title', 'Pesanan Terkirim')
@section('nav-info', 'Meja ' . $pesanan->meja->nomor_meja)

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto text-center">
        <h1 class="text-2xl font-bold mb-2">Pesanan Berhasil Dikirim!</h1>
        <p class="text-gray-500 mb-4">Silakan tunggu, pesanan Anda sedang diproses barista.</p>

        <ul class="text-left mb-4">
            @foreach ($pesanan->detailPesanans as $detail)
                <li class="flex justify-between border-b py-1">
                    <span>{{ $detail->produk->nama_produk }} x{{ $detail->jumlah }}</span>
                    <span>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>

        <p class="font-bold text-lg">Total: Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mt-2">Status: {{ $pesanan->status }}</p>
    </div>
@endsection
