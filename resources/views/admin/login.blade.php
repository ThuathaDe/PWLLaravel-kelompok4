@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
    <div class="max-w-sm mx-auto mt-20 bg-white p-6 rounded-lg shadow">
        <h1 class="text-xl font-bold mb-4 text-center">Login Admin</h1>

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2 mb-2">

            @error('password')
                <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
            @enderror

            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">
                Masuk
            </button>
        </form>

        <a href="/" class="block text-center text-sm text-gray-500 mt-4">Kembali ke beranda</a>
    </div>
@endsection
