<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - My Financial</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        /* Font: Inter for a modern, clean look */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8; /* A softer light gray */
            color: #333;
        }

        /* Nav link animations */
        .nav-link {
            position: relative;
            color: #4a5568; /* a charcoal gray */
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            padding: 0.75rem 1.25rem;
            border-radius: 9999px; /* full rounded */
            font-weight: 500;
        }

        .nav-link:hover {
            color: #1a202c; /* darker charcoal on hover */
            background-color: #e2e8f0; /* light gray hover background */
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .nav-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, #3182ce, #667eea); /* blue-purple gradient */
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(49, 130, 206, 0.4);
        }
        
        /* Subtle line under active link */
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: #3182ce;
            border-radius: 2px;
        }

        /* Hamburger icon animations */
        .hamburger-icon .line {
            width: 28px;
            height: 2px;
            background-color: #333;
            display: block;
            margin: 6px 0;
            transition: all 0.3s ease-in-out;
        }
        
        .hamburger-icon.open .line:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }
        .hamburger-icon.open .line:nth-child(2) {
            opacity: 0;
        }
        .hamburger-icon.open .line:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            
            <a href="/" class="text-3xl font-extrabold text-gray-900 tracking-wide">
                <span class="text-blue-600">My</span><span class="text-purple-600">Financial</span>
            </a>

            <div id="desktop-menu" class="hidden md:flex items-center space-x-6">
                <a href="/pemasukan" class="nav-link flex items-center gap-2 {{ Request::is('pemasukan*') ? 'active' : '' }}">
                    <i class="ri-money-dollar-circle-line text-lg"></i>
                    Pemasukan
                </a>
                <a href="/pengeluaran" class="nav-link flex items-center gap-2 {{ Request::is('pengeluaran*') ? 'active' : '' }}">
                    <i class="ri-wallet-3-line text-lg"></i>
                    Pengeluaran
                </a>
                <a href="/dashboard" class="nav-link flex items-center gap-2 {{ Request::is('dashboard*') || Request::is('/') ? 'active' : '' }}">
                    <i class="ri-dashboard-line text-lg"></i>
                    Dashboard
                </a>
                <a href="{{ route('budgets.index') }}" class="nav-link flex items-center gap-2 {{ Request::is('budgets*') ? 'active' : '' }}">
                    <i class="ri-pie-chart-2-line text-lg"></i>
                    Anggaran
                </a>
                <a href="/saldo-awal" class="nav-link flex items-center gap-2 {{ Request::is('saldo-awal*') ? 'active' : '' }}">
                    <i class="ri-bank-line text-lg"></i>
                    Saldo Awal
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('profile.edit') }}" class="text-gray-500 hover:text-gray-800 transition duration-200">
                    <i class="ri-user-line text-2xl"></i>
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-gray-800 transition duration-200">
                        <i class="ri-logout-box-r-line text-2xl"></i>
                    </button>
                </form>
            </div>

            <div id="hamburger-btn" class="hamburger-icon md:hidden cursor-pointer p-2">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
    </nav>

    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg py-4 transition-all duration-300 ease-in-out">
        <div class="flex flex-col items-center space-y-4 px-4">
            <a href="/pemasukan" class="nav-link w-full text-center flex items-center justify-center gap-2 {{ Request::is('pemasukan*') ? 'active' : '' }}">
                <i class="ri-money-dollar-circle-line"></i>
                Pemasukan
            </a>
            <a href="/pengeluaran" class="nav-link w-full text-center flex items-center justify-center gap-2 {{ Request::is('pengeluaran*') ? 'active' : '' }}">
                <i class="ri-wallet-3-line"></i>
                Pengeluaran
            </a>
            <a href="/dashboard" class="nav-link w-full text-center flex items-center justify-center gap-2 {{ Request::is('dashboard*') || Request::is('/') ? 'active' : '' }}">
                <i class="ri-dashboard-line"></i>
                Dashboard
            </a>
            <a href="{{ route('budgets.index') }}" class="nav-link w-full text-center flex items-center justify-center gap-2 {{ Request::is('budgets*') ? 'active' : '' }}">
                <i class="ri-pie-chart-2-line"></i>
                Anggaran
            </a>
            <a href="/saldo-awal" class="nav-link w-full text-center flex items-center justify-center gap-2 {{ Request::is('saldo-awal*') ? 'active' : '' }}">
                <i class="ri-bank-line"></i>
                Saldo Awal
            </a>
        </div>
        <div class="mt-4 border-t border-gray-200 pt-4 flex flex-col items-center space-y-4 px-4">
            <a href="{{ route('profile.edit') }}" class="nav-link w-full text-center flex items-center justify-center gap-2">
                <i class="ri-user-line"></i>
                Profil
            </a>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="nav-link w-full text-center flex items-center justify-center gap-2">
                    <i class="ri-logout-box-r-line"></i>
                    Log Out
                </button>
            </form>
        </div>
    </div>
    
    <main class="container mx-auto mt-8 p-4 flex-grow">
        @yield('content')
    </main>

    <script>
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        hamburgerBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            hamburgerBtn.classList.toggle('open');
        });

        // Close mobile menu when a link is clicked
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                hamburgerBtn.classList.remove('open');
            });
        });
    </script>
</body>
</html>