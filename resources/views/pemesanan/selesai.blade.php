@extends('layouts.app')

@section('title', 'Pesanan Terkirim')
@section('nav-info', 'Meja ' . $pesanan->meja->nomor_meja)

@section('content')
    <div class="border rounded-lg p-4 shadow bg-white max-w-lg mx-auto text-center">
        <p class="font-mono-label text-xs mb-2" style="color: var(--mustard-dark);">TIKET #{{ $pesanan->id }}</p>
        <h1 class="font-marker text-2xl mb-2">Pesanan Terkirim!</h1>
        <p class="text-sm mb-4" style="color: var(--ink-soft);">Silakan tunggu, barista sedang menyiapkan pesanan Anda.</p>

        <div class="rounded p-4 mb-4" style="background: var(--paper); border: 1px solid var(--paper-line);">
            <p class="font-mono-label text-xs mb-1" style="color: var(--ink-soft);">ESTIMASI SELESAI</p>
            <p class="font-marker text-3xl" style="color: var(--clay);">{{ $pesanan->waktuEstimasiSelesai->format('H:i') }}</p>
            <p class="text-sm mt-1" style="color: var(--ink-soft);">
                Sekitar {{ $pesanan->estimasiMenit }} menit lagi
                (<span id="hitung-mundur">menghitung...</span>)
            </p>
        </div>

        <ul class="text-left mb-4">
            @foreach ($pesanan->detailPesanans as $detail)
                <li class="flex justify-between py-1" style="border-bottom: 1px dashed var(--paper-line);">
                    <span>{{ $detail->produk->nama_produk }} x{{ $detail->jumlah }}</span>
                    <span>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>

        <p class="font-semibold text-lg">Total: Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
        <p class="font-mono-label text-xs mt-2" style="color: var(--ink-soft);">STATUS: {{ strtoupper($pesanan->status) }}</p>
    </div>

    <script>
        // Waktu target estimasi selesai, dikirim dari server (format ISO supaya akurat di semua timezone browser)
        const waktuTarget = new Date("{{ $pesanan->waktuEstimasiSelesai->toIso8601String() }}").getTime();
        const elemenHitungMundur = document.getElementById('hitung-mundur');

        function perbaruiHitungMundur() {
            const sisaMs = waktuTarget - new Date().getTime();

            if (sisaMs <= 0) {
                elemenHitungMundur.textContent = 'seharusnya sudah siap';
                return;
            }

            const menit = Math.floor(sisaMs / 60000);
            const detik = Math.floor((sisaMs % 60000) / 1000);
            elemenHitungMundur.textContent = `${menit} menit ${detik} detik lagi`;
        }

        perbaruiHitungMundur();
        setInterval(perbaruiHitungMundur, 1000);
    </script>
@endsection
