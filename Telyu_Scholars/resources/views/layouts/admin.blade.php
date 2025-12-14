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

        <div class="relative">
            <button
                type="button"
                onclick="document.getElementById('admin-menu').classList.toggle('hidden')"
                class="inline-flex items-center px-4 py-2 text-sm font-medium hover:bg-red-700 rounded"
            >
                Admin Tasks
                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- DROPDOWN --}}
            <div
                id="admin-menu"
                class="hidden absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg z-30 pointer-events-auto"
            >
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Dashboard
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

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                    >
                        Logout
                    </button>
                </form>
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

</body>
</html>
