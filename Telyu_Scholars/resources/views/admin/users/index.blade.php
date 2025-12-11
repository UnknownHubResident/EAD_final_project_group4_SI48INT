@extends('layouts.app') 

@section('content')
<div class="container">
    <h2>Manage All Users</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-secondary">{{ $user->role }}</span></td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        @if ($user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Deactivated</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info">Edit</a>

                        @if ($user->role !== 'admin')
                            <form action="{{ route('admin.users.toggle', $user) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="btn btn-sm btn-warning"
                                        onclick="return confirm('Are you sure you want to {{ $user->is_active ? 'DEACTIVATE' : 'ACTIVATE' }} this account?');">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('WARNING! Are you sure you want to permanently DELETE the user {{ $user->name }}?');">
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
@endsection
