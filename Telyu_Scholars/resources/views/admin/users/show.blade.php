@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">👤 Provider: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">← Back to List</a>
    </div>

    <div class="bg-white shadow rounded-lg border border-gray-200 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Account Information</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">Email Address</label>
                    <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">Account Status</label>
                    <span class="inline-block mt-1 px-3 py-1 text-sm font-semibold rounded-full {{ $user->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $user->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">Registration Date</label>
                    <p class="text-gray-900 font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">Last Update</label>
                    <p class="text-gray-900 font-medium text-sm text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>


    <h2 class="text-2xl font-bold text-gray-800 mb-4">Scholarships Posted ({{ $user->scholarships->count() }})</h2>

    <div class="grid gap-4">
        @forelse ($user->scholarships as $scholarship)
            <div class="bg-white border border-gray-200 rounded-lg p-5 flex justify-between items-center hover:shadow-md transition">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">{{ $scholarship->title }}</h3>
                    <p class="text-sm text-gray-500">Deadline: {{ $scholarship->deadline->format('M d, Y') }} | Amount: ${{ number_format($scholarship->amount, 0) }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.scholarships.edit', $scholarship) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.scholarships.destroy', $scholarship) }}" onsubmit="return confirm('Delete scholarship?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-yellow-50 border border-yellow-100 text-yellow-700 p-8 text-center rounded-lg">
                No scholarships have been posted by this provider yet.
            </div>
        @endforelse
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