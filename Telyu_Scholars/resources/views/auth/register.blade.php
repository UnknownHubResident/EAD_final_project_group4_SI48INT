<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Tel-U Scholars</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden p-8">

        {{-- Header --}}
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">Create an Account</h1>
        <p class="text-center text-gray-500 text-sm mb-6">Join us to explore scholarship opportunities</p>

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

        {{-- Registration Form --}}
        <form method="POST" action="{{ url('/register') }}" class="space-y-4">
            @csrf

            {{-- Full Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Enter your full name"
                    class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-red-900 shadow-sm">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    placeholder="name@example.com"
                    class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-red-900 shadow-sm">
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                    placeholder="Create a strong password"
                    class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-red-900 shadow-sm">
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    placeholder="Repeat your password"
                    class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-red-900 shadow-sm">
            </div>

            {{-- Role Selection --}}
            <div>
                <label for="intended_role" class="block text-sm font-medium text-gray-700 mb-1">Register as:</label>
                <select name="intended_role" id="intended_role" onchange="toggleStudentFields()" required
                        class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-red-900 shadow-sm bg-gray-50">
                    <option value="student">Student</option>
                    <option value="scholar_provider">Scholar Provider</option>
                </select>
            </div>

            {{-- Student Fields (conditional) --}}
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

            {{-- Submit Button --}}
            <button type="submit"
                    class="w-full bg-red-900 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-lg shadow-md transition">
                Register Account
            </button>
        </form>

        {{-- Footer --}}
        <p class="text-center text-sm text-gray-600 mt-6">
            Already have an account? 
            <a href="{{ url('/login') }}" class="text-red-900 font-bold hover:underline">Login here</a>
        </p>
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

</body>
</html>
