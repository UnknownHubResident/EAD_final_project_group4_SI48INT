@extends('layouts.admin') {{-- Assuming you have an Admin layout --}}

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-xl">
        <h1 class="text-3xl font-bold mb-6 text-red-700 border-b pb-2">⛔ Finalize Provider Rejection/Suspension</h1>

        <div class="bg-red-50 p-4 rounded-lg border border-red-200 mb-6">
            <h2 class="text-xl font-semibold mb-2 text-red-800">Provider Details</h2>
            <p><strong class="font-medium">User ID:</strong> {{ $user->id }}</p>
            <p><strong class="font-medium">Name:</strong> {{ $user->name }}</p>
            <p><strong class="font-medium">Email:</strong> {{ $user->email }}</p>
            <p class="mt-4 text-sm text-red-600">
                **Action Warning:** You are about to suspend this provider. They will lose dashboard access. The reason below will be shown to them upon login.
            </p>
        </div>

        {{-- The form submits to admin.reject.finalize (POST) --}}
        <form method="POST" action="{{ route('admin.reject.finalize', $user) }}" class="mt-6">
            @csrf
            
            <div class="mb-6">
                <label for="rejection_reason" class="block text-gray-700 text-sm font-bold mb-2">
                    Rejection/Suspension Reason (Optional, for provider feedback)
                </label>
                <textarea 
                    name="rejection_reason" 
                    id="rejection_reason" 
                    rows="4" 
                    class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500" 
                    placeholder="e.g., Incomplete profile documentation; Non-compliance with eligibility standards; Temporary account review. (Max 500 characters)"
                >{{ old('rejection_reason') }}</textarea>
                @error('rejection_reason')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-8">
                {{-- Button to initiate rejection (will trigger confirmation popup) --}}
                <button 
                    type="submit" 
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-150 focus:outline-none focus:shadow-outline" 
                    onclick="return confirm('FINAL CONFIRMATION: Are you sure you want to suspend {{ $user->name }}? This action is reversible via the Admin User List.');"
                >
                    Finalize Rejection/Suspension
                </button>
                
                {{-- Button to go back --}}
                <a href="{{ route('admin.pending') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                    ← Go Back to Pending List
                </a>
            </div>
        </form>
    </div>
@endsection