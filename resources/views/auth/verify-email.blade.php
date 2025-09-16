<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - Aplikasi Keuangan</title>
    
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
                    Verifikasi Alamat Email Anda
                </h1>
                <p class="text-base text-gray-600 animate-fadeIn delay-200">
                    Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik tautan yang kami kirimkan.
                </p>
                <p class="text-base text-gray-600 mt-2 animate-fadeIn delay-300">
                    Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkannya kembali.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 text-center animate-fadeIn delay-400">
                    Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif

            <div class="flex items-center justify-center mt-8 space-x-4 animate-fadeIn delay-500">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="py-3 px-6 rounded-xl font-bold bg-indigo-600 text-white shadow-lg transition-all duration-300 hover:bg-indigo-700 active:scale-95">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="py-3 px-6 rounded-xl font-bold bg-gray-200 text-gray-700 shadow-sm transition-all duration-300 hover:bg-gray-300 active:scale-95">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>