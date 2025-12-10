<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Student | Scholarship</title>
</head>
<body class="bg-gray-50 min-h-screen">

<nav class="bg-white shadow">
  <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
    <a href="{{ route('student.scholarships.index') }}" class="text-xl font-bold">Tel-U Scholars</a>
    <div class="space-x-4">
      @auth
        <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button class="text-sm text-red-600">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="text-sm text-blue-600">Login</a>
      @endauth
    </div>
  </div>
</nav>

<main class="py-8">
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
