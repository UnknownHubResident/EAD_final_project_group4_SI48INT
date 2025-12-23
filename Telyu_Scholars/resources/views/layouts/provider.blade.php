<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>External Provider | Scholarship</title>
</head>
{{-- Changed bg-gray-100 to bg-white to ensure the sides are white --}}
<body class="bg-white min-h-screen">

    {{-- Top Navbar: Keeping the red ONLY here as requested --}}
    <nav class="bg-[#8b1d1d]"> {{-- Professional Dark Red --}}
        <div class="max-w-screen-2xl mx-auto px-10 py-4 flex justify-between items-center text-white">
            <a href="{{ route('dashboard') }}" class="text-2xl font-black tracking-tighter">Provider Panel</a>
            
            <div class="relative inline-block text-left">
                <button type="button" class="inline-flex justify-center items-center rounded-md px-4 py-2 text-lg font-bold text-white hover:bg-white/10 focus:outline-none" id="provider-menu-button" onclick="document.getElementById('provider-menu').classList.toggle('hidden')">
                    My Actions
                    <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div class="origin-top-right absolute right-0 mt-2 w-64 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50" id="provider-menu">
                    <div class="py-2">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 block px-6 py-3 text-base font-bold hover:bg-gray-100">Dashboard</a>
                        <a href="{{ route('provider.scholarships.index') }}" class="text-gray-700 block px-6 py-3 text-base font-bold hover:bg-gray-100">Manage My Scholarships</a>
                        <a href="{{ route('provider.applications.index') }}" class="text-gray-700 block px-6 py-3 text-base font-bold hover:bg-gray-100">Review Applications</a>
                        <hr class="my-2 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 w-full text-left block px-6 py-3 text-base font-black hover:bg-red-50">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content: Pure White Background --}}
    <main class="bg-white">
        {{-- Removed max-w-7xl constraint here to let the child pages control the width --}}
        <div class="mx-auto">
            @if(session('success'))
                <div class="max-w-7xl mx-auto mt-4 px-4">
                    <div class="p-4 bg-green-100 text-green-700 rounded-xl font-bold border border-green-200">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Simple script to close menu when clicking outside --}}
    <script>
        window.onclick = function(event) {
            if (!event.target.matches('#provider-menu-button')) {
                var dropdowns = document.getElementsByClassName("origin-top-right");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (!openDropdown.classList.contains('hidden')) {
                        openDropdown.classList.add('hidden');
                    }
                }
            }
        }
    </script>
</body>
</html>