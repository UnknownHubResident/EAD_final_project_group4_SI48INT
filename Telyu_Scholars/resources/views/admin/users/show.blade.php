@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-indigo-700">👤 Provider Details: {{ $user->name }}</h1>

    <div class="bg-white p-6 rounded-lg shadow-xl">
        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Account Information</h2>
        
        <div class="grid grid-cols-2 gap-4 text-gray-700">
            <div>
                <p><strong class="font-medium">User ID:</strong> {{ $user->id }}</p>
                <p><strong class="font-medium">Role:</strong> <span class="px-2 py-0.5 bg-indigo-100 text-indigo-800 rounded-full text-sm">{{ $user->role }}</span></p>
                <p><strong class="font-medium">Status:</strong> 
                    @if ($user->is_approved)
                        <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-sm">Approved</span>
                    @else
                        <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded-full text-sm">Pending</span>
                    @endif
                </p>
            </div>
            <div>
                <p><strong class="font-medium">Email:</strong> {{ $user->email }}</p>
                <p><strong class="font-medium">Registered:</strong> {{ $user->created_at->format('M d, Y H:i') }}</p>
                <p><strong class="font-medium">Last Updated:</strong> {{ $user->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Future development section for Provider's scholarships and actions --}}
    <h2 class="text-2xl font-bold mt-8 mb-4">Scholarship Management</h2>

    <div class="p-6 bg-gray-50 border border-gray-200 rounded-lg">
        <p class="text-gray-600">This section will display all scholarships posted by {{ $user->name }} and allow the Admin to view, edit, or delete them.</p>
    </div>

    <p class="mt-8">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">← Back to All Users</a>
    </p>

@endsection