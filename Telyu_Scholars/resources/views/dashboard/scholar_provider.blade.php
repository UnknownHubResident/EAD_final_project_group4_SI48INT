<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Provider Dashboard</title>
</head>
<body>
    <div style="padding: 20px; background-color: #f0fdf4; border: 1px solid #4ade80;">
        <h1>💼 Scholar Provider Dashboard</h1>
        <p>Welcome, **{{ Auth::user()->name }}**! Your Provider account is now **active**.</p>
        <p>This page confirms successful Admin approval and correct final routing.</p>
        
        <hr>
        <h3>Provider Menu</h3>
        <ul>
            <li>Create New Scholarship Program</li>
            <li>Review Student Applications</li>
            <li>View Payment History</li>
        </ul>

        <p><small>Role: {{ Auth::user()->role }} | Approved: {{ Auth::user()->is_approved ? 'Yes' : 'No' }}</small></p>
        <form action="{{ route('logout') }}" method="POST"><button type="submit">Logout</button>@csrf</form>
    </div>
</body>
</html>
