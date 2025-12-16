<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Tel-U Scholars</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-red-600 py-6 text-center">
            <h1 class="text-2xl font-bold text-white uppercase tracking-wider">Create Account</h1>
        </div>

        <form method="POST" action="{{ url('/register') }}" class="p-8 space-y-5">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-50 p-4 border-l-4 border-red-500 text-red-700 text-sm mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500 shadow-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required 
                           class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm</label>
                    <input type="password" name="password_confirmation" required 
                           class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500 shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Register as:</label>
                <select name="intended_role" id="intended_role" onchange="toggleStudentFields()" required
                        class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500 shadow-sm bg-gray-50 font-medium">
                    <option value="student">Student</option>
                    <option value="scholar_provider">Scholar Provider</option>
                </select>
            </div>

            <div id="student_fields" class="space-y-4 pt-4 border-t border-gray-100">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest">Academic Details</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Student Number</label>
                        <input type="text" name="student_number" value="{{ old('student_number') }}" maxlength="12"
                               class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Year Batch</label>
                        <input type="text" name="year_batch" value="{{ old('year_batch') }}" maxlength="4"
                               class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Major</label>
                    <input type="text" name="study_major" value="{{ old('study_major') }}"
                           class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Degree Rank</label>
                    <select name="degree_rank" class="w-full rounded-lg border-gray-300 text-sm">
                        <option value="Bachelor">Bachelor</option>
                        <option value="Master">Master</option>
                        <option value="PhD">PhD</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 shadow-md transition">
                Register Account
            </button>

            <p class="text-center text-sm text-gray-600">
                Already have an account? <a href="{{ url('/login') }}" class="text-red-600 font-bold hover:underline">Login here</a>.
            </p>
        </form>
    </div>

    <script>
        function toggleStudentFields() {
            const role = document.getElementById('intended_role').value;
            const container = document.getElementById('student_fields');
            const inputs = container.querySelectorAll('input, select');

            if (role === 'student') {
                container.classList.remove('hidden');
                inputs.forEach(i => i.setAttribute('required', 'required'));
            } else {
                container.classList.add('hidden');
                inputs.forEach(i => i.removeAttribute('required'));
            }
        }
        document.addEventListener('DOMContentLoaded', toggleStudentFields);
    </script>

    <title>Register - Tel-U Scholar</title>
    {{-- Assuming you are using Tailwind CSS. If not installed via Vite, here is the CDN for testing: --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 m-4">
        
        {{-- Header Section --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Create an Account</h1>
            <p class="text-gray-500 text-sm mt-2">Join us to explore scholarship opportunities</p>
        </div>

        {{-- Error Alerts --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Registration Form --}}
        <form method="POST" action="{{ url('/register') }}" class="space-y-5">
            @csrf
            
            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Enter your full name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors text-sm">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    placeholder="name@example.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors text-sm">
            </div>

            {{-- Role Selection --}}
            <div>
                <label for="intended_role" class="block text-sm font-medium text-gray-700 mb-1">I want to register as a</label>
                <div class="relative">
                    <select name="intended_role" id="intended_role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors text-sm appearance-none bg-white">
                        <option value="student">Student (Standard User)</option>
                        <option value="scholar_provider">Scholar Provider (Requires Approval)</option>
                    </select>
                    {{-- Custom dropdown arrow --}}
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    placeholder="Create a strong password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors text-sm">
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    placeholder="Repeat your password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors text-sm">
            </div>

            {{-- Submit Button (Matches the Dark Red from image) --}}
            <button type="submit" 
                class="w-full bg-[#8B1E24] hover:bg-[#6b161b] text-white font-bold py-2.5 rounded-lg shadow-md hover:shadow-lg transform transition hover:-translate-y-0.5 duration-200">
                Register Account
            </button>
        </form>

        {{-- Footer Link --}}
        <div class="mt-8 text-center text-sm text-gray-600">
            <p>Already have an account? 
                <a href="{{ url('/login') }}" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                    Login here
                </a>
            </p>
        </div>

    </div>

</body>
</html>