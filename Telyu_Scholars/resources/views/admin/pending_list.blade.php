@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-red-700">👑 Pending Scholar Provider Requests</h1>

@if (count($pendingUsers) > 0)
    <p class="mb-4 text-gray-700">You have **{{ count($pendingUsers) }}** users awaiting approval.</p>

    <div class="space-y-4">
        @foreach ($pendingUsers as $user)
            <div class="p-4 border border-gray-200 bg-white rounded-lg shadow">
                <h3 class="text-xl font-semibold">{{ $user->name }} (ID: {{ $user->id }})</h3>
                <p class="text-gray-600">Email: <strong>{{ $user->email }}</strong></p>
                <p class="text-gray-600 mb-3">Requested Role: Scholar Provider</p>
                
                <div class="flex space-x-3 mt-4"> 
                    
                    {{-- 1. Approve (POST request, Correct) --}}
                    <form method="POST" action="{{ route('admin.approve', $user) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 font-bold transition duration-150">
                            ✅ Approve Provider
                        </button>
                    </form>

                    {{-- 2. Reject (GET link to the rejection form, CORRECT) --}}
                    <a href="{{ route('admin.reject.form', $user) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 font-bold transition duration-150 flex items-center">
                        ⛔ Reject Provider
                    </a>
                    
                </div>
                
            </div>
        @endforeach
    </div>

@else
    <div class="p-6 bg-red-100 text-red-700 border border-red-400 rounded-lg">
        <p class="font-bold text-lg">🎉 All pending requests have been approved! The list is clear.</p>
    </div>
@endif

<p class="mt-8">
    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">← Back to Admin Dashboard</a>
</p>

@endsection