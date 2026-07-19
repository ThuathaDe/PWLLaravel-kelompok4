@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('nav-info', 'Tambah Produk')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Tambah Produk</h1>

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-lg shadow p-6 max-w-lg space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <select name="kategori_id" class="w-full border rounded px-3 py-2">
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nama Produk</label>
            <input
                type="text"
                name="nama_produk"
                class="w-full border rounded px-3 py-2"
                value="{{ old('nama_produk') }}"
                required
            >
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Harga</label>
            <input
                type="number"
                step="0.01"
                name="harga"
                class="w-full border rounded px-3 py-2"
                value="{{ old('harga') }}"
                required
            >
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Stok</label>
            <input
                type="number"
                name="stok"
                min="0"
                class="w-full border rounded px-3 py-2"
                value="{{ old('stok', 0) }}"
                required
            >
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea
                name="deskripsi"
                class="w-full border rounded px-3 py-2"
                rows="4"
            >{{ old('deskripsi') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Foto</label>
            <input
                type="file"
                name="foto"
                class="w-full"
                accept="image/*"
            >
        </div>

        @if ($errors->any())
            <div class="text-red-600 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Simpan
            </button>

            <a href="{{ route('admin.produk.index') }}"
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                Batal
            </a>
        </div>
    </form>
@endsection