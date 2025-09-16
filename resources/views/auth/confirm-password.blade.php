<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Sandi - Aplikasi Keuangan</title>
    
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
            
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-3xl font-extrabold text-gray-900 mb-2 animate-fadeIn delay-100">
                    Konfirmasi Sandi
                </h1>
                <p class="text-base text-gray-600 animate-fadeIn delay-200">
                    Ini adalah area aman aplikasi. Silakan konfirmasi sandi Anda sebelum melanjutkan.
                </p>
            </div>
            
            <x-auth-session-status class="mb-6 text-center text-sm font-medium text-red-600" :status="session('status')" />

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-6 animate-fadeIn delay-300">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2v5a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2h6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 11V9m0 2h.01M12 11h-.01" />
                            </svg>
                        </div>
                        <x-text-input id="password" class="pl-12 pr-12 py-3 block w-full border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300"
                            type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                        
                        <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" id="togglePassword">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" id="eyeIcon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-8 animate-fadeIn delay-400">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-lg font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform active:scale-95">
                        Konfirmasi
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');
            
            const hiddenIcon = '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.701 0 3.336.508 4.755 1.402M10 12a2 2 0 11-4 0 2 2 0 014 0zm5.834 5.834A3 3 0 1012 15a3 3 0 003.834-2.166zM17 12a9 9 0 01-4.755 4.142M2.458 12C3.732 7.943 7.523 5 12 5c.421 0 .83.029 1.232.086M21 12c-1.274 4.057-5.064 7-9.542 7-1.701 0-3.336-.508-4.755-1.402" />';
            const visibleIcon = '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';

            togglePasswordBtn.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                eyeIcon.innerHTML = (type === 'password') ? visibleIcon : hiddenIcon;
            });
        });
    </script>
</body>
</html>