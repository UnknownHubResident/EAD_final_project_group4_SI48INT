@extends('layouts.provider') {{-- Assuming you will create this layout --}}

@section('content')
<div style="padding: 20px; background-color: #f0fdf4; border: 1px solid #4ade80;">
    <h1>💼 Scholar Provider Dashboard</h1>
    <p>Welcome, **{{ Auth::user()->name }}**! Your Provider account is now **active**.</p>
    <p>This page confirms successful Admin approval and correct final routing.</p>
    
    <hr class="my-4">
    
    <h3>Provider Menu</h3>
    <ul class="list-disc ml-6">
        <li><a href="{{ route('provider.scholarships.create') }}" class="text-blue-600 hover:underline">Create New Scholarship Program</a></li>
        <li><a href="{{ route('provider.scholarships.index') }}" class="text-blue-600 hover:underline">Manage Existing Scholarships</a></li>
        <li>Review Student Applications (Placeholder)</li>
        <li>View Payment History (Placeholder)</li>
    </ul>

    <p class="mt-4"><small>Role: {{ Auth::user()->role }} | Approved: {{ Auth::user()->is_approved ? 'Yes' : 'No' }}</small></p>
    
    {{-- ✅ CORRECTED: Logout form re-added --}}
    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" style="background-color: #f59e0b; color: white; padding: 8px 15px; border: none; cursor: pointer; border-radius: 4px;">Logout</button>
    </form>
</div>
@endsection