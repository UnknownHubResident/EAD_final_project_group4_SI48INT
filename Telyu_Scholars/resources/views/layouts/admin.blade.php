<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin | Scholarship</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

{{-- ================= NAVBAR ================= --}}
<nav class="bg-red-900 relative z-20">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center text-white">

        <a href="{{ route('dashboard') }}" class="text-xl font-bold">
            Admin Panel
        </a>

        {{-- SINGLE UNIFIED DROPDOWN ANCHOR --}}
        <div class="relative">
            <button 
                type="button" 
                onclick="toggleAdminMenu()" 
                class="inline-flex items-center px-4 py-2 font-semibold text-sm hover:bg-red-800 rounded focus:outline-none transition"
            >
                <span class="mr-1">{{ Auth::user()->name ?? 'test user1' }}</span>
                <span id="menu-arrow">∨</span>
            </button>

            {{-- DROPDOWN MENU PANEL --}}
            <div
                id="admin-menu"
                class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-30 pointer-events-auto border border-gray-100"
            >
                <div class="py-1">
                    <a href="{{ route('dashboard') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">
                        Dashboard
                    </a>

                    <hr class="border-gray-200">

                    <a href="#"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Pending Provider Applications
                    </a>

                    <a href="{{ route('admin.scholarships.index') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Manage Scholarships
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Manage Users
                    </a>

                    <a href="{{ route('admin.pending') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Pending Providers
                    </a>

                    <hr class="border-gray-200">

                    <a href="{{ route('admin.mentors.index') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-semibold text-green-700">
                        Manage All Mentors
                    </a>

                    <a href="{{ route('admin.bookings.index') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-semibold text-yellow-600">
                        Pending Consultations Booking
                    </a>

                    <hr class="border-gray-200">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold"
                        >
                            ← Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- ================= MAIN CONTENT ================= --}}
<main class="relative z-0 py-8">
    <div class="max-w-7xl mx-auto px-4">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')

    </div>
</main>

<script>
    function toggleAdminMenu() {
        const menu = document.getElementById('admin-menu');
        const arrow = document.getElementById('menu-arrow');
        
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            arrow.textContent = '▲';
        } else {
            menu.classList.add('hidden');
            arrow.textContent = '∨';
        }
    }

    // Close dropdown dynamically when clicking canvas space away from button
    window.addEventListener('click', function(e) {
        const menu = document.getElementById('admin-menu');
        const arrow = document.getElementById('menu-arrow');
        if (!e.target.closest('.relative')) {
            menu.classList.add('hidden');
            arrow.textContent = '∨';
        }
    });
</script>

</body>
</html>