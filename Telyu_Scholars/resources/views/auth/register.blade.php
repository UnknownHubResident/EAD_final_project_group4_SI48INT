<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Tel-U Scholars</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-12 px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        
        {{-- Header Section --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Create an Account</h1>
            <p class="text-gray-500 text-sm mt-2">Join us to explore scholarship opportunities</p>
        </div>

        {{-- Error Alerts --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r">
                <ul class="text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Registration Form --}}
        <form method="POST" action="{{ url('/register') }}" class="space-y-5">
            @csrf
            
            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Enter your full name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors text-sm">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    placeholder="name@example.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors text-sm">
            </div>

            {{-- Role Selection --}}
            <div>
                <label for="intended_role" class="block text-sm font-semibold text-gray-700 mb-1">I want to register as a</label>
                <select name="intended_role" id="intended_role" onchange="toggleStudentFields()" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors text-sm bg-white">
                    <option value="student" {{ old('intended_role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="scholar_provider" {{ old('intended_role') == 'scholar_provider' ? 'selected' : '' }}>Scholar Provider</option>
                </select>
            </div>

            {{-- Dynamic Student Fields Section --}}
            <div id="student_fields" class="space-y-4 pt-4 border-t border-gray-100">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Academic Details</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Student Number</label>
                        <input type="text" name="student_number" value="{{ old('student_number') }}" maxlength="12" placeholder="12 digits"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Year Batch</label>
                        <input type="text" name="year_batch" value="{{ old('year_batch') }}" maxlength="4" placeholder="YYYY"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Major</label>
                    <input type="text" name="study_major" value="{{ old('study_major') }}" placeholder="e.g. Informatics"
                           class="w-full rounded-lg border-gray-300 text-sm focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Degree Rank</label>
                    <select name="degree_rank" class="w-full rounded-lg border-gray-300 text-sm focus:ring-red-500 focus:border-red-500">
                        <option value="Bachelor" {{ old('degree_rank') == 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                        <option value="Master" {{ old('degree_rank') == 'Master' ? 'selected' : '' }}>Master</option>
                        <option value="PhD" {{ old('degree_rank') == 'PhD' ? 'selected' : '' }}>PhD</option>
                    </select>
                </div>
            </div>

            {{-- Passwords --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        placeholder="••••••••"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none text-sm">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirm</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        placeholder="••••••••"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none text-sm">
                </div>
            </div>

            {{-- Submit Button (Using Tel-U Dark Red) --}}
            <button type="submit" 
                class="w-full bg-[#8B1E24] hover:bg-[#6b161b] text-white font-bold py-3 rounded-lg shadow-md hover:shadow-lg transform transition active:scale-[0.98] duration-200 mt-4">
                Register Account
            </button>
        </form>

        {{-- Footer Link --}}
        <div class="mt-8 text-center text-sm text-gray-600 border-t pt-6">
            <p>Already have an account? 
                <a href="{{ url('/login') }}" class="text-red-600 hover:underline font-bold">
                    Login here
                </a>
            </p>
        </div>
    </div>

    <script>
        function toggleStudentFields() {
            const role = document.getElementById('intended_role').value;
            const container = document.getElementById('student_fields');
            const inputs = container.querySelectorAll('input, select');

            if (role === 'student') {
                container.style.display = 'block';
                inputs.forEach(i => i.setAttribute('required', 'required'));
            } else {
                container.style.display = 'none';
                inputs.forEach(i => i.removeAttribute('required'));
            }
        }
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', toggleStudentFields);
    </script>

</body>
</html>