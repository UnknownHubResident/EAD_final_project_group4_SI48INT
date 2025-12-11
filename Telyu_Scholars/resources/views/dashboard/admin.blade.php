<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <div style="padding: 20px; background-color: #fef2f2; border: 1px solid #f87171;">
        <h1>🚨 Admin Control Panel</h1>
        <p>Welcome, **{{ Auth::user()->name }}**! Access granted via 'admin' role.</p>
        <p>This page confirms the security check passed.</p>
        
        <hr>
        <h3>Admin Tasks</h3>
        <ul>
            <li><a href="{{ route('admin.pending') }}">View Pending Provider Applications (PLACEHOLDER)</a></li>
            <li>Manage All Users</li>
            <li>System Configuration</li>
        </ul>

        <p><small>Role: {{ Auth::user()->role }} | Approved: {{ Auth::user()->is_approved ? 'Yes' : 'No' }}</small></p>
        <form action="{{ route('logout') }}" method="POST"><button type="submit">Logout</button>@csrf</form>
    </div>
</body>
</html>
