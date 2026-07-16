@extends('layouts.app')

@section('title', 'Pesan Menu')
@section('nav-info', 'Meja ' . $meja->nomor_meja)

@section('content')
    <h1 class="text-2xl font-bold mb-6">Menu Coffee Shop</h1>

    <form action="{{ route('pemesanan.store') }}" method="POST" id="form-pesanan">
        @csrf
        <input type="hidden" name="meja_id" value="{{ $meja->id }}">

        @foreach ($kategoris as $kategori)
            <h2 class="text-lg font-semibold mt-6 mb-3">{{ $kategori->nama_kategori }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($kategori->produks as $produk)
                    <div class="bg-white rounded-lg shadow p-4">
                        @if ($produk->foto_path)
                            <img src="{{ asset('storage/' . $produk->foto_path) }}" class="w-full h-32 object-cover rounded mb-2">
                        @endif
                        <p class="font-semibold text-blue-500">{{ $produk->nama_produk }}</p>
                        <p class="text-sm text-gray-500 mb-2">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>

                        <label class="text-sm">Jumlah:</label>
                        <input type="number" min="0" value="0"
                               name="items[{{ $produk->id }}][jumlah]"
                               class="w-full border rounded px-2 py-1">
                        <input type="hidden" name="items[{{ $produk->id }}][produk_id]" value="{{ $produk->id }}">
                    </div>
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="mt-6 bg-blue-500 text-white px-6 py-3 rounded font-semibold">
            Kirim Pesanan
        </button>
    </form>

    <script>
        // Hapus item dengan jumlah 0 sebelum submit, supaya validasi 'items.*.jumlah min:1' tidak gagal
        document.getElementById('form-pesanan').addEventListener('submit', function () {
            this.querySelectorAll('input[name$="[jumlah]"]').forEach(function (input) {
                if (parseInt(input.value) === 0) {
                    input.closest('.bg-white').querySelectorAll('input').forEach(i => i.disabled = true);
                }
            });
        });
    </script>
@endsection
