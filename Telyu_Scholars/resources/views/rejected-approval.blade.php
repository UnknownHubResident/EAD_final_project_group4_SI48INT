<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 border-t-4 border-red-600 text-center">
        <div class="text-5xl mb-4">🚫</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Account Suspended</h1>
        <p class="text-gray-600 mb-4">
            We're sorry, <span class="font-semibold text-gray-900">{{ Auth::user()->name }}</span>.
        </p>
        <p class="text-sm text-gray-500 mb-8 leading-relaxed">
            Your account application has been rejected or your access has been suspended. Please contact support if you believe this is an error.
        </p>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full border border-red-600 text-red-600 hover:bg-red-50 font-bold py-2 px-4 rounded transition duration-200">
                Logout
            </button>
        </form>
    </div>
</body>
</html>