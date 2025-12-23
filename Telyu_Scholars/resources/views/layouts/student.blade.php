<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    {{-- Navigation Bar --}}
    <nav class="bg-[#8b1d1d] shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                {{-- Logo Side --}}
                <div class="flex items-center">
                    <a href="{{ route('student.scholarships.index') }}" class="flex items-center gap-2 text-white">
                        <span class="text-2xl">🎓</span>
                        <span class="font-black text-xl tracking-tighter uppercase">Student Panel</span>
                    </a>
                </div>

                {{-- Right Side Menu --}}
                <div class="flex items-center gap-4">
                    
                    @auth
                        {{-- Show this only if user IS logged in --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 text-white hover:bg-[#a12323] px-4 py-2 rounded-lg transition-colors font-bold">
                                {{ Auth::user()->name }}
                                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 text-gray-800">
                                
                                <a href="{{ route('student.dashboard') }}" class="block px-4 py-3 hover:bg-gray-50 flex items-center gap-3">
                                    <span class="text-lg"></span> Dashboard
                                </a>

                                <a href="{{ route('student.scholarships.index') }}" class="block px-4 py-3 hover:bg-gray-50 flex items-center gap-3 font-medium text-gray-700">
                                    <span class="text-lg"></span> Find Scholarships
                                </a>

                                <a href="{{ route('student.applications.index') }}" class="block px-4 py-3 hover:bg-gray-50 flex items-center gap-3 font-medium text-gray-700">
                                    <span class="text-lg"></span> Application View
                                </a>

                                <div class="border-t border-gray-100 my-1"></div>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 hover:bg-red-50 text-red-600 flex items-center gap-3 font-bold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Show this if user is NOT logged in --}}
                        <a href="{{ route('login') }}" class="text-white font-bold hover:underline px-4">Login</a>
                        <a href="{{ route('register') }}" class="bg-white text-[#8b1d1d] px-4 py-2 rounded-lg font-bold hover:bg-gray-100 transition-colors">Register</a>
                    @endauth

                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

</body>
</html>