<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approval</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 border-t-4 border-yellow-500 text-center">
        <div class="text-5xl mb-4">⚠️</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Account Pending Review</h1>
        <p class="text-gray-600 mb-6">
            Thank you for registering, <span class="font-semibold text-gray-900">{{ Auth::user()->name }}</span>!
        </p>
        <p class="text-sm text-gray-500 mb-8">
            Your application is currently being reviewed by an administrator. You will gain access to the full Provider Dashboard once approved.
        </p>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                Logout
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100 flex justify-between text-xs text-gray-400 uppercase tracking-widest">
            <span>Role: {{ Auth::user()->role }}</span>
            <span>Approved: {{ Auth::user()->is_approved ? 'Yes' : 'No' }}</span>
        </div>
    </div>
</body>
</html>