@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto py-6">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">User Management</h1>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($user->role === 'admin') bg-red-100 text-red-800 
                            @elseif($user->role === 'scholar_provider') bg-green-100 text-green-800 
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $user->is_approved ? 'Active' : 'Deactivated' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        
                        {{-- Action Button 1: Provider Detail (Requirement 3) --}}
                        @if ($user->role === 'scholar_provider')
                            <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Details</a>
                        @endif

                        {{-- Action Button 2 & 3: Toggle Status & Delete (Requirement 4) --}}
                        @if ($user->role !== 'admin')
                        {{-- Toggle Status Form --}}
                        <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" 
                                class="text-sm px-3 py-1 rounded 
                                {{ $user->is_approved ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white"
                                onclick="return confirm('Are you sure you want to {{ $user->is_approved ? 'DEACTIVATE' : 'ACTIVATE' }} this account?')"
                            >
                                {{ $user->is_approved ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        
                        {{-- Delete Form --}}
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded"
                                onclick="return confirm('⚠️ WARNING: This will permanently DELETE {{ $user->name }}. Are you sure?')">
                                Delete
                            </button>
                        </form>
                        @endif
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</div>
@endsection
