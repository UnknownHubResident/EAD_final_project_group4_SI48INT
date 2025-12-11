<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
</head>
<body>
    <div style="padding: 20px; background-color: #e9f5ff; border: 1px solid #a0c3ff;">
        <h1>📚 Student Dashboard</h1>
        <p>Welcome, **{{ Auth::user()->name }}**! Your student portal is active.</p>
        <p>This page confirms successful routing for a standard user.</p>
        
        <hr>
        <h3>Student Menu</h3>
        <ul>
            <li><a href =" {{ route('student.scholarships.index')}}">View Available Scholarships</a></li>
            <li>Submit an Application</li>
            <li>Update Profile</li>
        </ul>

        <p><small>Role: {{ Auth::user()->role }} | Approved: {{ Auth::user()->is_approved ? 'Yes' : 'No' }}</small></p>
        <form action="{{ route('logout') }}" method="POST"><button type="submit">Logout</button>@csrf</form>
    </div>
</body>
</html>
