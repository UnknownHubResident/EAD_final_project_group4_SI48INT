<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Approval</title>
</head>
<body>
    <div style="text-align: center; margin-top: 100px; padding: 20px; border: 1px solid #ffcc00; background-color: #fffacd;">
        <h1>⚠️ Account Pending Review</h1>
        <p>Thank you for registering as a Scholar Provider, **{{ Auth::user()->name }}**!</p>
        <p>Your application is currently being reviewed by an administrator. You will gain access to the full Provider Dashboard once approved.</p>
        <p>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; cursor: pointer;">
                    Logout
                </button>
            </form>
        </p>
        <p><small>Role: {{ Auth::user()->role }} | Approved: {{ Auth::user()->is_approved ? 'Yes' : 'No' }}</small></p>
    </div>
</body>
</html>
