<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Admin | Scholarship</title>
</head>
<body class="bg-gray-100 min-h-screen">
<nav class="bg-blue-700">
  <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center text-white">
    <a href="{{ route('provider.scholarships.index') }}" class="text-xl font-bold">Admin Panel</a>
    <div class="space-x-4">
      <a href="{{ route('provider.scholarships.index') }}" class="text-sm">Manage Scholarships</a>
      <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button class="text-sm">Logout</button>
      </form>
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
