<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Keuangan</title>
    @vite('resources/css/app.css')
    <style>
        /* Mengatur latar belakang halaman */
        body {
            /* Pastikan path gambar sudah benar */
            background-image: url("{{ asset('images/wp-keuangan.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Animasi kustom */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 1s ease-out forwards;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slideInRight {
            animation: slideInRight 0.8s ease-out forwards;
        }
        
        /* Overlay untuk membuat teks lebih mudah dibaca di atas gambar */
        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            /* Mengurangi transparansi overlay agar gambar latar belakang lebih terlihat */
            background-color: rgba(255, 255, 255, 0.5); /* Nilai 0.5 membuat gambar 50% terlihat */
            z-index: 1; /* Z-index yang lebih rendah agar tidak menutupi konten utama */
        }
    </style>
</head>
<body class="antialiased text-gray-900 flex flex-col min-h-screen relative">
    
    <div class="overlay"></div>
    
    <header class="fixed top-0 right-0 p-8 z-30 animate-slideInRight">
        @if (Route::has('login'))
            <div class="flex items-center space-x-6">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition-colors duration-200">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition-colors duration-200">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="py-2 px-6 rounded-full font-bold bg-gray-200 text-gray-700 shadow-sm transition-all duration-300 hover:bg-gray-300 active:scale-95">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="py-2 px-6 rounded-full font-bold bg-indigo-600 text-white shadow-lg transition-all duration-300 hover:bg-indigo-700 active:scale-95">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </header>

    <main class="flex-grow flex items-center justify-center p-8 relative z-20"> <div class="w-full max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-24 items-center z-30">
            
            <div class="animate-slideInLeft p-4">
                <h1 class="text-6xl md:text-7xl font-extrabold leading-tight mb-4">
                    <span class="block text-gray-800">Kelola</span>
                    <span class="block text-indigo-600">Finansial Anda</span>
                    <span class="block text-gray-800">dengan Mudah.</span>
                </h1>
                <p class="mt-6 text-lg md:text-xl text-gray-600 leading-relaxed pr-8">
                    Aplikasi ini membantu Anda mencatat pemasukan dan pengeluaran, membuat anggaran, dan melihat visualisasi data yang menarik untuk mengelola keuangan pribadi Anda dengan lebih baik.
                </p>
            </div>

            <div class="p-10 md:p-14 rounded-3xl shadow-2xl transform transition-all duration-500 hover:shadow-3xl animate-slideInRight bg-gradient-to-br from-indigo-500 to-purple-600 text-white">
                <div class="flex items-center justify-center mb-6">
                    <h2 class="text-3xl font-extrabold text-white">
                        Fitur Unggulan
                    </h2>
                </div>
                
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-200 text-lg">
                    <li class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2m-4 0V3m0 2h4m-4 0a2 2 0 00-2 2v2m4-2h-4a2 2 0 00-2 2v2" />
                        </svg>
                        <span>Pencatatan Transaksi Harian</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M18 12h-2a2 2 0 00-2 2v4a2 2 0 002 2h2m-4-10v0" />
                        </svg>
                        <span>Visualisasi Data Interaktif</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m-6 6a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Pengingat dan Anggaran Otomatis</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Ekspor Laporan Keuangan</span>
                    </li>
                </ul>
            </div>
        </div>
    </main>
</body>
</html>