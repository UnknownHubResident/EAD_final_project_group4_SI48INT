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

        {{-- DYNAMIC REASON BOX --}}
        <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-8 text-left">
            <p class="text-xs font-black text-red-700 uppercase tracking-widest mb-2">Reason for Suspension:</p>
            <p class="text-sm text-red-900 leading-relaxed font-medium">
                @if(Auth::user()->rejection_reason)
                    "{{ Auth::user()->rejection_reason }}"
                @else
                    Your account application has been rejected or your access has been suspended. Please contact support if you believe this is an error.
                @endif
            </p>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3 px-4 rounded-xl transition duration-200 shadow-md shadow-red-100">
                Logout & Exit
            </button>
        </form>

        <p class="mt-6 text-xs text-gray-400 font-medium">
            email contact: support@telkomuniversity.ac.id
        </p>
    </div>
</body>
</html>