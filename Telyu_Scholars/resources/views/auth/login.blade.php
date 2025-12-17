<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Tel-U Scholars</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden p-8">

        <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">Welcome Back</h1>
        <p class="text-center text-gray-500 text-sm mb-6">Login to your account</p>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    required
                    class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                    class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-red-900 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition"
            >
                Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Don’t have an account?
            <a href="{{ url('/register') }}" class="text-red-600 font-semibold hover:underline">
                Register here
            </a>
        </p>

    </div>

</body>
</html>
