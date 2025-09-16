<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Kata Sandi - Aplikasi Keuangan</title>
    
    @vite('resources/css/app.css')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #eef2f5;
            background-image: url("{{ asset('images/wp-keuangan.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slideInRight {
            animation: slideInRight 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }
        .delay-700 { animation-delay: 0.7s; }
        .delay-800 { animation-delay: 0.8s; }
        .delay-900 { animation-delay: 0.9s; }

        .soft-shadow {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 relative">
    
    <div class="w-full max-w-4xl mx-auto rounded-3xl overflow-hidden soft-shadow flex">
        <div class="hidden md:flex flex-1 items-center justify-center p-8 bg-gradient-to-br from-indigo-500 to-purple-600 animate-slideInLeft">
            <div class="text-center text-white p-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 21.6c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8z" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 10.4c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4zm0 0l-3 3v3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h2 class="text-3xl font-bold mb-2 tracking-wide">Kelola Finansial Anda</h2>
                <p class="text-indigo-200 text-sm leading-relaxed">Solusi cerdas untuk mencatat, mengelola, dan merencanakan keuangan pribadi Anda dengan mudah.</p>
            </div>
        </div>

        <div class="flex-1 bg-white p-8 sm:p-10 lg:p-12 rounded-3xl md:rounded-l-none animate-slideInRight">
            
            <x-auth-session-status class="mb-6 text-center text-sm font-medium text-green-600" :status="session('status')" />

            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-3xl font-extrabold text-gray-900 mb-2 animate-fadeIn delay-100">
                    Lupa Kata Sandi?
                </h1>
                <p class="text-base text-gray-600 animate-fadeIn delay-200">
                    Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
                </p>
            </div>
            
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6 animate-fadeIn delay-300">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.5a2.5 2.5 0 01-5 0V12" />
                            </svg>
                        </div>
                        <x-text-input id="email" class="pl-12 pr-4 py-3 block w-full border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@email.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-8 animate-fadeIn delay-400">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-lg font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform active:scale-95">
                        Kirim Tautan Reset Password
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center text-base text-gray-600 animate-fadeIn delay-500">
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 hover:underline transition-colors duration-200">
                    Kembali ke Halaman Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>