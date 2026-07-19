@extends('layouts.app')

@section('title', 'Pesan Menu')
@section('nav-info', 'Meja ' . $meja->nomor_meja)

@section('content')
    <h1 class="text-2xl font-bold mb-6">Menu Coffee Shop</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('pemesanan.store') }}" method="POST" id="form-pesanan">
        @csrf
        <input type="hidden" name="meja_id" value="{{ $meja->id }}">

        @foreach ($kategoris as $kategori)
            <h2 class="text-lg font-semibold mt-6 mb-3">{{ $kategori->nama_kategori }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($kategori->produks as $produk)
                    <div class="bg-white rounded-lg shadow p-4">

                        @if ($produk->foto_path)
                            <img src="{{ asset('storage/' . $produk->foto_path) }}"
                                 style="width: 100%; height: 128px; object-fit: cover; object-position: center; border-radius: 6px; display: block; margin-bottom: 8px;">
                        @endif

                        <p class="font-semibold">{{ $produk->nama_produk }}</p>

                        <p class="text-sm text-gray-500 mb-2">
                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                        </p>

                        <p class="text-sm text-gray-500 mb-2">
                            {{ $produk->deskripsi }}
                        </p>

                        {{-- TAMPILKAN STOK --}}
                        @if($produk->stok > 0)
                            <p class="text-sm text-green-600 font-semibold mb-2">
                                Stok: {{ $produk->stok }}
                            </p>
                        @else
                            <p class="text-sm text-red-600 font-semibold mb-2">
                                ❌ Stok Habis
                            </p>
                        @endif

                        <label class="text-sm">Jumlah:</label>

                        <div class="flex items-center gap-2 mt-1">

                            {{-- TOMBOL MINUS --}}
                            <button type="button"
                                    class="qty-minus"
                                    data-produk-id="{{ $produk->id }}"
                                    aria-label="Kurangi jumlah"
                                    @if($produk->stok == 0) disabled @endif
                                    style="
                                        border:1px solid #d1d5db;
                                        border-radius:6px;
                                        padding:3px 10px;
                                        @if($produk->stok == 0)
                                            background:#d1d5db;
                                            cursor:not-allowed;
                                        @else
                                            background:#fff;
                                        @endif
                                    ">
                                -
                            </button>

                            {{-- INPUT JUMLAH --}}
                            <input type="number"
                                   min="0"
                                   max="{{ $produk->stok }}"
                                   value="0"
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                                   name="items[{{ $produk->id }}][jumlah]"
                                   class="qty-input flex-1 border px-2 py-1 text-center"
                                   data-produk-id="{{ $produk->id }}"
                                   data-stok="{{ $produk->stok }}"
                                   @if($produk->stok == 0) readonly @endif>

                            {{-- TOMBOL PLUS --}}
                            <button type="button"
                                    class="qty-plus"
                                    data-produk-id="{{ $produk->id }}"
                                    data-stok="{{ $produk->stok }}"
                                    aria-label="Tambah jumlah"
                                    @if($produk->stok == 0) disabled @endif
                                    style="
                                        border:1px solid #d1d5db;
                                        border-radius:6px;
                                        padding:3px 10px;
                                        @if($produk->stok == 0)
                                            background:#d1d5db;
                                            cursor:not-allowed;
                                        @else
                                            background:#fff;
                                        @endif
                                    ">
                                +
                            </button>
                        </div>

                        <input type="hidden"
                               name="items[{{ $produk->id }}][produk_id]"
                               value="{{ $produk->id }}">

                    </div>
                @endforeach
            </div>
        @endforeach

        <button type="submit"
                class="mt-6 bg-blue-500 text-white px-6 py-3 rounded font-semibold">
            Kirim Pesanan
        </button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('form-pesanan');
            if (!form) return;

            // Tombol + dan -
            form.addEventListener('click', function (e) {

                const btnPlus = e.target.closest('.qty-plus');
                const btnMinus = e.target.closest('.qty-minus');

                if (!btnPlus && !btnMinus) return;

                const produkId = (btnPlus ? btnPlus : btnMinus).dataset.produkId;

                const input = form.querySelector(`input.qty-input[data-produk-id="${produkId}"]`);

                if (!input) return;

                const current = parseInt(input.value || '0', 10);

                // Tombol +
                if (btnPlus) {

                    const stok = parseInt(btnPlus.dataset.stok);

                    if (current < stok) {
                        input.value = current + 1;
                    } else {
                        alert('Stok produk tidak mencukupi!');
                    }

                } else {
                    // Tombol -
                    input.value = Math.max(0, current - 1);
                }
            });

            // Ketik manual
            form.addEventListener('input', function (e) {

                if (!e.target.classList.contains('qty-input')) return;

                let v = parseInt(e.target.value || '0', 10);
                const stok = parseInt(e.target.dataset.stok || '0', 10);

                if (Number.isNaN(v) || v < 0) v = 0;

                if (v > stok) {
                    v = stok;
                    alert('Jumlah melebihi stok yang tersedia!');
                }

                e.target.value = v;
            });

            // Hapus item jumlah 0 sebelum submit
            form.addEventListener('submit', function () {

                this.querySelectorAll('input[name$="[jumlah]"]').forEach(function (input) {

                    if (parseInt(input.value) === 0) {

                        input.closest('.bg-white')
                             .querySelectorAll('input')
                             .forEach(i => i.disabled = true);
                    }
                });
            });
        });
    </script>
@endsection