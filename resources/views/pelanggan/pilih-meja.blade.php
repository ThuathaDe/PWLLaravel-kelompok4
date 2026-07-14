@extends('layouts.app')

@section('title', 'Pilih Meja')

@section('content')
    <div class="max-w-sm mx-auto mt-20 bg-white p-6 rounded-lg shadow text-center">
        <h1 class="text-xl font-bold mb-4">Masukkan Nomor Meja</h1>

        <form action="{{ route('pelanggan.mulaiPesan') }}" method="GET">
            <input type="text" name="nomor_meja" placeholder="Contoh: 1" class="w-full border rounded px-3 py-2 mb-3" required>
            <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded">
                Lihat Menu
            </button>
        </form>
    </div>
@endsection
