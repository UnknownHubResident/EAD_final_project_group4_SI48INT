<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Provider Requests</title>
</head>
<body>
    <div style="padding: 20px; background-color: #fef2f2; border: 1px solid #f87171;">
        <h1>👑 Pending Scholar Provider Requests</h1>
        
        @if (session('success'))
            <p style="color: green; border: 1px solid green; padding: 10px;">{{ session('success') }}</p>
        @endif
        
        <p>You have **{{ count($pendingUsers) }}** users awaiting approval.</p>

        <hr>

        @forelse ($pendingUsers as $user)
            <div style="border: 1px solid #ccc; margin-bottom: 15px; padding: 10px; background-color: white;">
                <h3>{{ $user->name }} (ID: {{ $user->id }})</h3>
                <p>Email: <strong>{{ $user->email }}</strong></p>
                <p>Requested Role: Scholar Provider</p>
                
                <form method="POST" action="{{ route('admin.approve', $user) }}" style="margin-top: 10px;">
                    @csrf
                    <button type="submit" style="background-color: #4CAF50; color: white; padding: 8px 15px; border: none; cursor: pointer; font-weight: bold;">
                        ✅ Approve Provider
                    </button>
                </form>
            </div>
        @empty
            <p style="font-size: 1.2em; color: #f87171;">🎉 All pending requests have been approved! The list is clear.</p>
        @endforelse

        <p style="margin-top: 20px;"><a href="{{ route('dashboard') }}">Back to Admin Dashboard</a></p>
    </div>
</body>
</html>
