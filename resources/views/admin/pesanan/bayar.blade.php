@extends('layouts.app')

@section('title', 'Proses Pembayaran #' . $pesanan->id)
@section('nav-info', 'Pembayaran #' . $pesanan->id)

@section('content')
<div class="max-w-2xl mx-auto bg-white border rounded-lg p-6 shadow-sm">
    <div class="mb-6 flex justify-between items-center border-b pb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Proses Pembayaran #{{ $pesanan->id }}</h1>
            <p class="text-xs text-gray-500">Meja: <span class="font-bold text-gray-700">Meja {{ $pesanan->meja->nomor_meja ?? $pesanan->meja_id }}</span></p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded">
            ← Batal
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="mb-6">
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Ringkasan Pesanan</h2>
        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
            @foreach($detailPesanans as $detail)
                <div class="flex justify-between py-2 text-sm text-gray-700 border-b border-gray-200 last:border-0">
                    <span>{{ $detail->produk->nama_produk }} <span class="text-gray-400">x{{ $detail->jumlah }}</span></span>
                    <span class="font-medium text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
            <div class="flex justify-between items-center pt-3 font-bold text-lg text-gray-900 mt-2">
                <span>Total Tagihan</span>
                <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Menyesuaikan route name dari web.php: admin.pesanan.bayarFormSubmit -->
    <form action="{{ route('admin.pesanan.bayarFormSubmit', $pesanan->id) }}" method="POST">
        @csrf

        <div class="mb-5">
            <label for="uang_dibayar" class="block text-sm font-semibold text-gray-700 mb-2">Uang Yang Diterima (Rp)</label>
            <input type="number" 
                   name="uang_dibayar" 
                   id="uang_dibayar" 
                   min="{{ $pesanan->total_harga }}" 
                   placeholder="Masukkan nominal uang tunai..." 
                   class="w-full border rounded p-3 text-lg font-semibold focus:ring-2 focus:ring-purple-400 focus:outline-none"
                   oninput="hitungKembalian(this.value)" 
                   required autofocus>
        </div>

        <div class="bg-purple-50 p-4 rounded-lg border border-purple-100 flex justify-between items-center mb-6">
            <span class="text-sm font-medium text-purple-800">Uang Kembalian</span>
            <div class="text-2xl font-bold text-purple-900" id="label-kembalian">
                Rp 0
            </div>
        </div>

        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-bold text-md shadow transition">
            Konfirmasi & Cetak Lunas
        </button>
    </form>
</div>

<script>
    const totalTagihan = {{ $pesanan->total_harga }};

    function hitungKembalian(uangMasuk) {
        const uang = parseFloat(uangMasuk) || 0;
        const labelKembalian = document.getElementById('label-kembalian');
        
        if (uang >= totalTagihan) {
            const kembalian = uang - totalTagihan;
            labelKembalian.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
            labelKembalian.className = "text-2xl font-bold text-green-600";
        } else {
            labelKembalian.textContent = 'Uang Kurang';
            labelKembalian.className = "text-sm font-semibold text-red-500";
        }
    }
</script>
@endsection