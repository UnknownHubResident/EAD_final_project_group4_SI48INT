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

   
    <h2 class="text-2xl font-bold mt-8 mb-4">Scholarship Management ({{ $user->scholarships->count() }} Total)</h2>

<div class="space-y-4">
    @forelse ($user->scholarships as $scholarship)
        <div class="flex justify-between items-center p-4 border border-gray-200 bg-white rounded-lg shadow">
            <div>
                <h3 class="text-lg font-semibold">{{ $scholarship->title }}</h3>
                <p class="text-sm text-gray-600">Deadline: {{ $scholarship->deadline->format('M d, Y') }} | Amount: {{ number_format($scholarship->amount, 0) }}</p>
                <p class="text-sm text-gray-600">Status: 
                    <span class="px-2 py-0.5 text-xs rounded-full {{ $scholarship->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $scholarship->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
            <div class="flex space-x-2">
                {{-- Admin actions go here (e.g., View, Edit, Delete) --}}
                <a href="{{ route('admin.scholarships.edit', $scholarship) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                <form method="POST" action="{{ route('admin.scholarships.destroy', $scholarship) }}" onsubmit="return confirm('Are you sure you want to delete this scholarship?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="p-6 bg-yellow-50 border border-yellow-300 rounded-lg">
            <p class="text-yellow-800">This provider has not posted any scholarships yet.</p>
        </div>
    @endforelse
</div>

    <p class="mt-8">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">← Back to All Users</a>
    </p>

@endsection