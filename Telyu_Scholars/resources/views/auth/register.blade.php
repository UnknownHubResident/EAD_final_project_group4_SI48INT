<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
</head>
<body>
    <h1>Register an Account</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <h3>Please fix the following errors:</h3>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf
        
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="password_confirmation">Confirm Password:</label><br>
        <input type="password" id="password_confirmation" name="password_confirmation" required><br><br>

        <label for="intended_role">I want to register as a:</label><br>
        <select name="intended_role" id="intended_role" onchange="toggleStudentFields()" required>
            <option value="student" {{ old('intended_role', 'student') == 'student' ? 'selected' : '' }}>Student (Standard User)</option>
            <option value="scholar_provider" {{ old('intended_role') == 'scholar_provider' ? 'selected' : '' }}>Scholar Provider (Requires Admin Approval)</option>
        </select><br><br>

        <div id="student_fields">
            <h3>Student Academic Details (Required for Student Role)</h3>
            
            <label for="student_number">Student Number (e.g., 12 digits):</label><br>
            <input type="text" id="student_number" name="student_number" value="{{ old('student_number') }}" maxlength="12" required><br><br>

            <label for="study_major">Study Major:</label><br>
            <input type="text" id="study_major" name="study_major" value="{{ old('study_major') }}" required><br><br>

            <label for="year_batch">Year Batch (e.g., 2024):</label><br>
            <input type="text" id="year_batch" name="year_batch" value="{{ old('year_batch') }}" maxlength="4" required><br><br>

            <label for="degree_rank">Degree Rank:</label><br>
            <select name="degree_rank" id="degree_rank" required>
                <option value="">Select Degree</option>
                <option value="Bachelor" {{ old('degree_rank') == 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                <option value="Master" {{ old('degree_rank') == 'Master' ? 'selected' : '' }}>Master</option>
                <option value="PhD" {{ old('degree_rank') == 'PhD' ? 'selected' : '' }}>Doctor of Philosophy (PhD)</option>
            </select><br><br>
        </div>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="{{ url('/login') }}">Login here</a>.</p>

    <script>
        function toggleStudentFields() {
        const roleSelect = document.getElementById('intended_role');
        const studentFieldsDiv = document.getElementById('student_fields');
        
        // Get all required fields within the student fields div
        const studentFields = studentFieldsDiv.querySelectorAll('input[required], select[required]');

        if (roleSelect.value === 'student') {
            studentFieldsDiv.style.display = 'block';
            
            // 1. If Student, fields ARE required
            studentFields.forEach(field => {
                field.setAttribute('required', 'required');
            });
            
        } else { // Role is 'scholar_provider'
            studentFieldsDiv.style.display = 'none';
            
            // 2. If Provider, fields are NOT required (remove the attribute)
            studentFields.forEach(field => {
                field.removeAttribute('required');
            });
        }
    }
    
    // Run the function immediately when the page loads
    document.addEventListener('DOMContentLoaded', toggleStudentFields);
    </script>
</body>
</html>