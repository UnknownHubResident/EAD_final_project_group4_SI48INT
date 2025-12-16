@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">User Management</h1>

    {{-- Session Messages --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white text-sm">
                @foreach ($users as $user)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                        <div class="text-gray-500 text-xs">{{ $user->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-indigo-100 text-indigo-800' }}">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                            @if ($user->is_rejected) bg-red-100 text-red-800
                            @elseif($user->is_approved) bg-green-100 text-green-800 
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $user->is_rejected ? 'Suspended' : ($user->is_approved ? 'Active' : 'Pending') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <div class="flex justify-end items-center space-x-2">
                            @if ($user->is_rejected)
                                <form method="POST" action="{{ route('admin.unreject', $user) }}">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition" onclick="return confirm('Lift suspension?')">
                                        Unreject
                                    </button>
                                </form>
                            @else
                                @if ($user->role === 'scholar_provider')
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Details</a>
                                @endif

                                @if ($user->role !== 'admin')
                                    <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="px-3 py-1 rounded text-xs font-medium text-white transition {{ $user->is_approved ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }}">
                                            {{ $user->is_approved ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                @endif
                            @endif

                            @if ($user->role !== 'admin')
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-gray-100 hover:bg-red-600 hover:text-white text-gray-600 px-3 py-1 rounded text-xs transition" onclick="return confirm('Delete user?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection