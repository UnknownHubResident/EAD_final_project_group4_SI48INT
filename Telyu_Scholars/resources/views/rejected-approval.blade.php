<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Suspended</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { text-align: center; padding: 30px; border: 1px solid #cc3333; background-color: #ffeaea; border-radius: 12px; max-width: 500px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { color: #cc3333; margin-top: 0; font-size: 2em; }
        .reason-box { margin: 25px auto; padding: 15px; border-left: 5px solid #cc3333; background-color: #fff; max-width: 90%; text-align: left; border-radius: 6px; }
        .reason-box p { margin: 5px 0; line-height: 1.4; }
        .btn-group button, .btn-group a { padding: 10px 20px; border: none; cursor: pointer; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block; margin: 5px; transition: background-color 0.2s; }
        .btn-logout { background-color: #007bff; color: white; }
        .btn-logout:hover { background-color: #0056b3; }
        .btn-register { background-color: #343a40; color: white; }
        .btn-register:hover { background-color: #1d2124; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⛔ Account Suspended</h1>
        <p>We regret to inform you that your Scholar Provider application or account access has been **suspended**.</p>
        
        @if (Auth::user()->rejection_reason)
            <div class="reason-box">
                <p style="font-weight: bold; color: #cc3333;">Reason for Suspension:</p>
                <p>{{ Auth::user()->rejection_reason }}</p>
            </div>
        @else
            <p style="margin-top: 15px; color: #666;">No specific reason was provided by the administrator at this time.</p>
        @endif
        
        <p style="margin-top: 25px;">
            <p><small style="color: #666;">If you believe this is an error, or need to re-register, please choose an option below:</small></p>
        </p>
        
        <div class="btn-group">
            <a href="{{ route('register') }}" class="btn-register">
                Go to Registration Page
            </a>
            
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">
                    Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>
