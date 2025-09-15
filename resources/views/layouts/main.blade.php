<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Aplikasi Keuangan</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold">Aplikasi Keuangan</a>
            <div class="flex items-center space-x-4">
                <a href="/pemasukan" class="hover:underline">Pemasukan</a>
                <a href="/pengeluaran" class="hover:underline">Pengeluaran</a>
                <a href="/dashboard" class="hover:underline">Dashboard</a>
                <a href="{{ route('budgets.index') }}" class="hover:underline">Anggaran</a>
                <a href="/saldo-awal" class="hover:underline">Saldo Awal</a>
                <a href="{{ route('profile.edit') }}" class="hover:underline">Profil</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:underline ml-4">Log Out</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="container mx-auto mt-8 p-4">
        @yield('content')
    </main>
</body>
</html>