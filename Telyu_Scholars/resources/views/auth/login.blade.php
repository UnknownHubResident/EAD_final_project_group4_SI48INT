<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Tel-U Scholars</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-red-600 py-6 text-center text-white">
            <h1 class="text-2xl font-bold uppercase">Welcome Back</h1>
            <p class="text-sm opacity-80">Login to your dashboard</p>
        </div>

        <form method="POST" action="{{ url('/login') }}" class="p-8 space-y-6">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-50 p-3 rounded text-red-700 text-sm border border-red-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" required 
                       class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required 
                       class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500 shadow-sm">
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 shadow-md transition">
                Sign In
            </button>

            <p class="text-center text-sm text-gray-600">
                New user? <a href="{{ url('/register') }}" class="text-red-600 font-bold hover:underline">Register here</a>.
            </p>
        </form>
    </div>
</body>
</html>