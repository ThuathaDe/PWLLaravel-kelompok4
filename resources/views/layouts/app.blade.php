<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Coffee Shop')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <span class="font-bold text-lg">☕ Coffee Shop Self-Ordering</span>
        <div class="text-sm text-gray-500 flex items-center gap-4">
            
            @yield('nav-info', '')
            @if (session('is_admin'))
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 hover:underline">Logout</button>
                </form>
            @endif
        </div>
    </nav>

    <main class="p-6">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>