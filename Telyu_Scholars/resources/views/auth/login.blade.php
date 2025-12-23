<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Tel-U Scholars</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white w-full max-w-md p-8 rounded-xl shadow-lg border border-gray-200">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Welcome Back</h1>
            <p class="text-gray-500 text-sm mt-2">Login to your account</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm border border-green-200">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 outline-none transition shadow-sm">
            </div>
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 outline-none transition shadow-sm">
            </div>
            <button type="submit" class="w-full bg-red-700 text-white py-3 rounded-lg font-bold hover:bg-red-800 shadow-md transition-all">Sign In</button>
        </form>

        <div class="mt-8 text-center border-t pt-6">
            <p class="text-sm text-gray-600">Don't have an account? <a href="{{ url('/register') }}" class="text-red-600 font-bold hover:underline ml-1">Register here</a></p>
        </div>
    </div>
</body>
</html>