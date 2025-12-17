
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Student | Scholarship</title>
</head>
<body class="bg-gray-100 min-h-screen">
<nav class="bg-red-600">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center text-white">
        <a href="{{ route('student.scholarships.index') }}" class="text-xl font-bold">Tel-U Scholars</a>
        
        <div class="space-x-4">
            @auth
            {{-- Dropdown Container --}}
            <div class="relative inline-block text-left">
                <button type="button" class="inline-flex justify-center w-full rounded-md px-3 py-1 text-sm font-medium text-white hover:bg-blue-500 focus:outline-none" id="student-menu-button" aria-expanded="true" aria-haspopup="true" onclick="document.getElementById('student-menu').classList.toggle('hidden')">
                    {{ auth()->user()->name }}
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50" role="menu" aria-orientation="vertical" aria-labelledby="student-menu-button" tabindex="-1" id="student-menu">
                    <div class="py-1" role="none">
                        {{-- Only show Dashboard link if the user is authenticated (which they are) --}}
                        <a href="{{ route('dashboard') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1">Dashboard</a>
                        
                        {{-- Link to the functional Application Dashboard (student.dashboard) --}}
                        <a href="{{ route('student.applications.index') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1">My Applications</a>

                        {{-- The public scholarship index --}}
                        <a href="{{ route('student.scholarships.index') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1">Scholarship Directory</a>
                        
                        <form method="POST" action="{{ route('logout') }}" role="none">
                            @csrf
                            <button type="submit" class="text-gray-700 w-full text-left block px-4 py-2 text-sm hover:bg-red-100" role="menuitem" tabindex="-1">
                                Logout
                            </button>
                        </form>

    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Student | Scholarship</title>
    </head>
    <body class="bg-gray-100 min-h-screen">
    <nav class="bg-red-800">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center text-white">
            <a href="{{ route('student.scholarships.index') }}" class="flex items-center space-x-3">
                <img
                    src="{{ asset('image/logo.png') }}"
                    alt="Tel-U Scholars Logo"
                    class="h-10 w-auto"
                >
                <span class="text-xl font-bold">
                    Tel-U Scholars
                </span>
            </a>

            
            <div class="space-x-4">
                @auth
                {{-- Dropdown Container --}}
                <div class="relative inline-block text-left">
                    <button type="button" class="inline-flex justify-center w-full rounded-md px-3 py-1 text-sm font-medium text-white hover:bg-blue-500 focus:outline-none" id="student-menu-button" aria-expanded="true" aria-haspopup="true" onclick="document.getElementById('student-menu').classList.toggle('hidden')">
                        {{ auth()->user()->name }}
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50" role="menu" aria-orientation="vertical" aria-labelledby="student-menu-button" tabindex="-1" id="student-menu">
                        <div class="py-1" role="none">
                            {{-- Only show Dashboard link if the user is authenticated (which they are) --}}
                            <a href="{{ route('dashboard') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1">Dashboard</a>
                            
                            {{-- The public scholarship index --}}
                            <a href="{{ route('student.scholarships.index') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1">Scholarship Directory</a>
                            
                            <form method="POST" action="{{ route('logout') }}" role="none">
                                @csrf
                                <button type="submit" class="text-gray-700 w-full text-left block px-4 py-2 text-sm hover:bg-red-100" role="menuitem" tabindex="-1">
                                    Logout
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
                
                @else
                    {{-- Visible when not logged in (e.g., public index page) --}}
                    <a href="{{ route('login') }}" class="text-white text-sm hover:underline">Login</a>
                @endauth
            </div>

        </div>
    </nav>

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
    </body>
    </html>