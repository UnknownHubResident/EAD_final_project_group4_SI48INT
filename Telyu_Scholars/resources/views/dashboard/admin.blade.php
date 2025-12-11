@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1>🚨 Admin Control Panel</h1>
    <p>Welcome, **{{ Auth::user()->name }}**! Access granted via 'admin' role.</p>
    <p>This page confirms the security check passed.</p>
    
    <hr class="my-4">
    
    <h3>Admin Tasks</h3>
    <ul class="list-disc ml-6">
        <li><a href="{{ route('admin.pending') }}" class="text-blue-600 hover:underline">View Pending Provider Applications</a></li>
        <li><a href="{{ route('admin.scholarships.index')}}" class="text-blue-600 hover:underline">Manage All Scholarships</a></li>
        <li><a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">Manage All Users</a></li>
        <li>System Configuration (Placeholder)</li>
    </ul>

    <p class="mt-4"><small>Role: {{ Auth::user()->role }} | Approved: {{ Auth::user()->is_approved ? 'Yes' : 'No' }}</small></p>

    
    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Logout</button>
    </form>
</div>
@endsection