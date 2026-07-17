@extends('layouts.app')

@section('title', 'Kelola Produk')
@section('nav-info', 'Kelola Produk')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kelola Produk</h1>
        <a href="{{ route('admin.produk.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Tambah Produk
        </a>
        
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3">Nama Produk</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produks as $produk)
                    <tr class="border-b">
                        <td class="px-4 py-3">{{ $produk->nama_produk }}</td>
                        <td class="px-4 py-3">{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-4 py-3">Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('admin.produk.edit', $produk) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('admin.produk.destroy', $produk) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $produks->links() }}

        <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 text-white px-4 py-2 ">
            Kembali ke Dashboard
        </a>
    </div>
@endsection
