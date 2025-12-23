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

    {{-- Single Wrapper --}}
    <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
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
                    {{-- Column 1: User Info --}}
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                        <div class="text-gray-500 text-xs">{{ $user->email }}</div>
                    </td>

                    {{-- Column 2: Role --}}
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-indigo-100 text-indigo-800' }}">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </td>

                    {{-- Column 3: Status --}}
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                            @if ($user->is_rejected) bg-red-100 text-red-800
                            @elseif($user->is_approved) bg-green-100 text-green-800 
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $user->is_rejected ? 'Suspended' : ($user->is_approved ? 'Active' : 'Pending') }}
                        </span>
                    </td>

                    {{-- Column 4: Actions --}}
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end items-center space-x-2">
                            
                            {{-- Action Set A: If user is suspended/rejected --}}
                            @if ($user->is_rejected)
                                <form method="POST" action="{{ route('admin.unreject', $user) }}">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition" onclick="return confirm('Lift suspension?')">
                                        Unreject
                                    </button>
                                </form>

                            {{-- Action Set B: If user is Active or Pending --}}
                            @else
                                {{-- 1. Details link (Providers only) --}}
                                @if ($user->role === 'scholar_provider')
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs">Details</a>
                                @endif

                                {{-- 2. Toggle Activate/Deactivate (Non-Admins only) --}}
                                @if ($user->role !== 'admin')
                                    <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="inline">
                                        @csrf @method('PUT')
                                        <button type="submit" 
                                            class="px-3 py-1 rounded text-xs font-medium text-white transition {{ $user->is_approved ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }}"
                                            onclick="return confirm('Are you sure you want to {{ $user->is_approved ? 'DEACTIVATE' : 'ACTIVATE' }} this account?')">
                                            {{ $user->is_approved ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    
                                    {{-- 3. Shortcut to the formal suspension form --}}
                                    @if($user->role === 'scholar_provider' && $user->is_approved)
                                         <a href="{{ route('admin.reject.form', $user) }}" class="bg-red-100 text-red-700 px-3 py-1 rounded text-xs hover:bg-red-200 transition">Suspend</a>
                                    @endif
                                @endif
                            @endif

                            {{-- 4. Delete (Available for all non-admins regardless of status) --}}
                            @if ($user->role !== 'admin')
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-gray-100 hover:bg-red-600 hover:text-white text-gray-600 px-3 py-1 rounded text-xs transition" 
                                        onclick="return confirm('⚠️ WARNING: This will permanently DELETE {{ $user->name }}. Are you sure?')">
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