<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>external provider | Scholarship</title>
</head>
<body class="bg-gray-100 min-h-screen">
<nav class="bg-green-700">
  <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center text-white">
   <a href="{{ route('dashboard') }}" class="text-xl font-bold">Provider Panel</a>
    <div class="relative inline-block text-left">
    <button type="button" class="inline-flex justify-center w-full rounded-md px-3 py-1 text-sm font-medium text-white hover:bg-green-600 focus:outline-none" id="provider-menu-button" aria-expanded="true" aria-haspopup="true" onclick="document.getElementById('provider-menu').classList.toggle('hidden')">
        My Actions
        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>

    <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50" role="menu" aria-orientation="vertical" aria-labelledby="provider-menu-button" tabindex="-1" id="provider-menu">
        <div class="py-1" role="none">
            <a href="{{ route('dashboard') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1">Dashboard</a>
            <a href="{{ route('provider.scholarships.index') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1">Manage My Scholarships</a>
            
            <form method="POST" action="{{ route('logout') }}" role="none">
                @csrf
                <button type="submit" class="text-gray-700 w-full text-left block px-4 py-2 text-sm hover:bg-red-100" role="menuitem" tabindex="-1">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
  </div>
</nav>

<main class="py-6">
  <div class="max-w-7xl mx-auto px-4">
    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif
    @yield('content')
  </div>
</main>
</body>
</html>
