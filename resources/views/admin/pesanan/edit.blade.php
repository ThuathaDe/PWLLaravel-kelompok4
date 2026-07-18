@extends('layouts.app')

@section('title', 'Edit Pesanan #' . $pesanan->id)
@section('nav-info', 'Edit Pesanan #' . $pesanan->id)

@section('content')
<div class="max-w-4xl mx-auto bg-white border rounded-lg p-6 shadow-sm">
    <div class="mb-6 flex justify-between items-center border-b pb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Edit Pesanan #{{ $pesanan->id }}</h1>
            <p class="text-xs text-gray-500">Status Saat Ini: <span class="uppercase font-semibold text-yellow-600 bg-yellow-100 px-2 py-0.5 rounded">{{ $pesanan->status }}</span></p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded">
            ← Kembali ke Dashboard
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
            <strong>Terjadi kesalahan:</strong>
            <ul class="list-disc list-inside mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pesanan.update', $pesanan->id) }}" method="POST" id="form-edit-pesanan">
        @csrf
        @method('PUT')

        <!-- Pilihan Meja -->
        <div class="mb-6">
            <label for="meja_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Meja</label>
            <select name="meja_id" id="meja_id" class="w-full md:w-1/3 border rounded p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @foreach($mejas as $meja)
                    <option value="{{ $meja->id }}" {{ $pesanan->meja_id == $meja->id ? 'selected' : '' }}>
                        Meja {{ $meja->nomor_meja }}
                    </option>
                @endforeach
            </select>
        </div>

        <hr class="mb-6">

        <!-- Area Manajemen Item / Menu Pemesanan -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-md font-bold text-gray-700">Daftar Menu Dipesan</h2>
                <button type="button" onclick="tambahBarisItem()" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-xs font-semibold">
                    + Tambah Menu Baru
                </button>
            </div>

            <!-- Header Tabel Item -->
            <div class="grid grid-cols-12 gap-3 mb-2 font-semibold text-xs text-gray-500 bg-gray-50 p-2 rounded">
                <div class="col-span-6 md:col-span-7">Nama Produk</div>
                <div class="col-span-3 md:col-span-2 text-center">Jumlah</div>
                <div class="col-span-3 md:col-span-2 text-right">Subtotal</div>
                <div class="col-span-12 md:col-span-1 text-center mt-2 md:mt-0">Aksi</div>
            </div>

            <!-- Container Baris Item -->
            <div id="wrapper-item" class="space-y-3">
                @foreach($detailPesanans as $index => $detail)
                    <div class="grid grid-cols-12 gap-3 items-center p-2 border border-gray-100 rounded row-item">
                        <!-- Select Produk -->
                        <div class="col-span-6 md:col-span-7">
                            <select name="items[{{ $index }}][produk_id]" 
                                    class="w-full border rounded p-2 text-sm select-produk select2-init" 
                                    onchange="hitungUlangBaris(this)">
                                <option value="" data-harga="0">-- Pilih Menu --</option>
                                @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}" 
                                            data-harga="{{ $produk->harga }}" 
                                            {{ $detail->produk_id == $produk->id ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }} (Rp {{ number_format($produk->harga, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Kuantitas -->
                        <div class="col-span-3 md:col-span-2 text-center">
                            <input type="number" 
                                   name="items[{{ $index }}][jumlah]" 
                                   value="{{ $detail->jumlah }}" 
                                   min="1" 
                                   class="w-full border rounded p-2 text-sm text-center input-jumlah" 
                                   oninput="hitungUlangBaris(this)">
                        </div>

                        <!-- Teks Subtotal (Di-render via JS) -->
                        <div class="col-span-3 md:col-span-2 text-right text-sm font-semibold text-gray-700 label-subtotal">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </div>

                        <!-- Tombol Hapus Baris -->
                        <div class="col-span-12 md:col-span-1 text-center">
                            <button type="button" onclick="hapusBarisItem(this)" class="text-red-500 hover:text-red-700 font-bold text-sm">
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Perhitungan Total Akhir -->
        <div class="bg-gray-50 p-4 rounded-lg border flex flex-col items-end mb-6">
            <span class="text-xs text-gray-500 font-medium mb-1">Total Estimasi Tagihan Baru</span>
            <div class="text-2xl font-bold text-gray-900" id="grand-total">
                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
            </div>
        </div>

        <div class="flex gap-3 justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded font-semibold text-sm shadow-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    let itemIndex = {{ count($detailPesanans) }};

    function tambahBarisItem() {
        const wrapper = document.getElementById('wrapper-item');
        
        const html = `
            <div class="grid grid-cols-12 gap-3 items-center p-2 border border-gray-100 rounded row-item">
                <div class="col-span-6 md:col-span-7">
                    <select name="items[${itemIndex}][produk_id]" class="w-full border rounded p-2 text-sm select-produk" onchange="hitungUlangBaris(this)" required>
                        <option value="" data-harga="0">-- Pilih Menu --</option>
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}">
                                {{ $produk->nama_produk }} (Rp {{ number_format($produk->harga, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-3 md:col-span-2 text-center">
                    <input type="number" name="items[${itemIndex}][jumlah]" value="1" min="1" class="w-full border rounded p-2 text-sm text-center input-jumlah" oninput="hitungUlangBaris(this)" required>
                </div>
                <div class="col-span-3 md:col-span-2 text-right text-sm font-semibold text-gray-700 label-subtotal">
                    Rp 0
                </div>
                <div class="col-span-12 md:col-span-1 text-center">
                    <button type="button" onclick="hapusBarisItem(this)" class="text-red-500 hover:text-red-700 font-bold text-sm">
                        Hapus
                    </button>
                </div>
            </div>
        `;
        
        wrapper.insertAdjacentHTML('beforeend', html);
        itemIndex++;
    }

    function hapusBarisItem(button) {
        const row = button.closest('.row-item');
        row.remove();
        hitungGrandTotal();
    }

    function hitungUlangBaris(element) {
        const row = element.closest('.row-item');
        const selectProduk = row.querySelector('.select-produk');
        const inputJumlah = row.querySelector('.input-jumlah');
        const labelSubtotal = row.querySelector('.label-subtotal');

        const selectedOption = selectProduk.options[selectProduk.selectedIndex];
        const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
        const jumlah = parseInt(inputJumlah.value) || 0;

        const subtotal = harga * jumlah;
        labelSubtotal.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

        hitungGrandTotal();
    }

    function hitungGrandTotal() {
        let grandTotal = 0;
        const rows = document.querySelectorAll('.row-item');

        rows.forEach(row => {
            const selectProduk = row.querySelector('.select-produk');
            const inputJumlah = row.querySelector('.input-jumlah');
            
            if (selectProduk.selectedIndex !== -1) {
                const selectedOption = selectProduk.options[selectProduk.selectedIndex];
                const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
                const jumlah = parseInt(inputJumlah.value) || 0;
                grandTotal += (harga * jumlah);
            }
        });

        document.getElementById('grand-total').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }
</script>
@endsection