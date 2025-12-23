<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Tel-U Scholars</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-12 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-2xl font-bold text-center text-gray-900">Create an Account</h1>
        
        @if ($errors->any())
            <div class="my-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r">
                <ul class="text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Register as a</label>
                <select name="intended_role" id="intended_role" onchange="toggleStudentFields()" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm bg-white">
                    <option value="student" {{ old('intended_role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="scholar_provider" {{ old('intended_role') == 'scholar_provider' ? 'selected' : '' }}>Scholar Provider</option>
                </select>
            </div>

            <div id="student_fields" class="space-y-4 pt-4 border-t border-gray-100">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Student Number</label>
                        <input type="text" name="student_number" value="{{ old('student_number') }}" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Year Batch</label>
                        <input type="text" name="year_batch" value="{{ old('year_batch') }}" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Major</label>
                    <input type="text" name="study_major" value="{{ old('study_major') }}" class="w-full rounded-lg border-gray-300 text-sm">
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

            <div class="grid grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border rounded-lg text-sm">
                <input type="password" name="password_confirmation" placeholder="Confirm" required class="w-full px-4 py-2 border rounded-lg text-sm">
            </div>

            <button type="submit" class="w-full bg-[#8B1E24] text-white font-bold py-3 rounded-lg shadow-md mt-4">Register Account</button>
        </form>
        <p class="mt-8 text-center text-sm text-gray-600 border-t pt-6">Already have an account? <a href="{{ url('/login') }}" class="text-red-600 font-bold hover:underline">Login here</a></p>
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
        document.addEventListener('DOMContentLoaded', toggleStudentFields);
    </script>
</body>
</html>