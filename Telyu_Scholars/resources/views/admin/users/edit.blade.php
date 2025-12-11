@extends('layouts.app') 

@section('content')
<div class="container">
    <h2>Edit User: {{ $user->name }}</h2>
    <p>User Email: <strong>{{ $user->email }}</strong></p>
    <p>User Role: <span class="badge bg-primary">{{ $user->role }}</span></p>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PATCH')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">User Name</label>
            <input type="text" 
                   class="form-control" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $user->name) }}" 
                   required>
        </div>
        
        <button type="submit" class="btn btn-success">Update User Details</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancel and Back to List</a>
    </form>
    
    <hr class="mt-4">

    <h4>Account Status</h4>
    <p>
        Current Status: 
        @if ($user->is_active)
            <span class="badge bg-success">Active</span>
        @else
            <span class="badge bg-danger">Deactivated</span>
        @endif
        
        @if ($user->is_active === false)
             — This user cannot log in.
        @endif
    </p>

</div>
@endsection