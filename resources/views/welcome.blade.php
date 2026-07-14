@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="max-w-md mx-auto text-center mt-20">
        <h1 class="text-2xl font-bold mb-8">☕ Coffee Shop Self-Ordering</h1>

        <a href="{{ route('admin.login') }}" class="block bg-blue-500 text-white px-6 py-4 rounded mb-4 font-semibold hover:bg-blue-600 transition">
            Masuk sebagai Admin
        </a>

        <a href="{{ route('pelanggan.pilihMeja') }}" class="block bg-green-500 text-white px-6 py-4 rounded font-semibold hover:bg-green-600 transition">
            Pesan sebagai Pelanggan
        </a>
    </div>
@endsection