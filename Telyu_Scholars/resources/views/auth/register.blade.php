<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
</head>
<body>
    <h1>Register an Account</h1>

    @if ($errors->any())
        <div style="color: red;">
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
        <select name="intended_role" id="intended_role" required>
            <option value="student">Student (Standard User)</option>
            <option value="scholar_provider">Scholar Provider (Requires Admin Approval)</option>
        </select><br><br>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="{{ url('/login') }}">Login here</a>.</p>
</body>
</html>