<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tel-U Scholars - Student Portal</title>
    <style>
        .dropdown-menu {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-red-700 to-red-800 shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo & Brand -->
            <a href="{{ route('student.scholarships.index') }}" class="flex items-center space-x-3 hover:opacity-80 transition">
                @if(file_exists(public_path('image/logo.png')))
                    <img src="{{ asset('image/logo.png') }}" alt="Tel-U Scholars" class="h-10 w-auto">
                @else
                    <div class="h-10 w-10 bg-white rounded-full flex items-center justify-center text-red-700 font-bold">T</div>
                @endif
                <span class="text-xl font-bold text-white hidden md:block">Tel-U Scholars</span>
            </a>

            <!-- Navigation Menu -->
            <div class="flex items-center space-x-6">
                @auth
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button type="button" class="inline-flex items-center space-x-2 px-4 py-2 rounded-lg text-white bg-red-600 hover:bg-red-500 transition-colors text-sm font-medium" onclick="toggleDropdown()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 overflow-hidden dropdown-menu">
                            <div class="px-4 py-3 bg-gray-50 border-b">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="inline-block px-2 py-1 mt-1 bg-blue-100 text-blue-800 rounded text-xs font-medium uppercase">
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </p>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2-2l6.553-3.276A1 1 0 0112 2.25a1 1 0 01.553.276l6.553 3.276m-9.553 4.5v10.5m0 0a1 1 0 001 1h1a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h1a1 1 0 001-1V8.75m0 0H9m0 0V5.25a1 1 0 011-1h2a1 1 0 011 1v3.75M9 8.75h6"></path>
                                    </svg>
                                    Dashboard
                                </a>

                                <a href="{{ route('student.scholarships.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                    </svg>
                                    Scholarships
                                </a>

                                <a href="{{ route('student.applications.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    My Applications
                                </a>

                                <a href="{{ route('application.history') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Application History
                                </a>

                                <div class="border-t my-1"></div>

                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Login Link (Not Authenticated) -->
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-white bg-red-600 hover:bg-red-500 transition-colors text-sm font-medium">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-start">
                    <svg class="w-5 h-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Success!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start">
                    <svg class="w-5 h-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Error!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold mb-4">About Tel-U Scholars</h3>
                    <p class="text-sm text-gray-400">Connecting talented students with scholarship opportunities at Telkom University.</p>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4">Quick Links</h3>
                    <ul class="text-sm space-y-2">
                        <li><a href="{{ route('student.scholarships.index') }}" class="text-gray-400 hover:text-white transition">Scholarships</a></li>
                        <li><a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition">Dashboard</a></li>
                        @auth
                            <li><a href="{{ route('application.history') }}" class="text-gray-400 hover:text-white transition">My Applications</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4">Contact</h3>
                    <p class="text-sm text-gray-400">Email: scholars@telkom.co.id</p>
                    <p class="text-sm text-gray-400">Phone: +62 21 XXXX XXXX</p>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-sm text-gray-500 text-center">
                <p>&copy; 2025 Tel-U Scholars. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Dropdown Toggle -->
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button');
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>