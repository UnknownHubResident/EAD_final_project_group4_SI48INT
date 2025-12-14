@extends('layouts.student')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-4 text-blue-600">📚 Student Dashboard</h1>

    {{-- Username is displayed here, as requested --}}
    <p class="mb-4 text-lg">Welcome, **{{ Auth::user()->name }}**! Your student portal is active.</p>
    <p class="mb-6 text-gray-600">This page confirms successful routing for a standard user.</p>

    <h2 class="text-xl font-semibold mb-3">Student Menu</h2>
    <ul class="list-disc list-inside space-y-2 ml-4">
        {{-- Links use Tailwind classes for a modern look --}}
        <li>
            <a href="{{ route('student.scholarships.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                View Available Scholarships
            </a>
        </li>
        <li class="text-gray-600">Submit an Application (Placeholder)</li>
        <li class="text-gray-600">Update Profile (Placeholder)</li>
    </ul>

    <hr class="my-6">

    <p class="text-sm text-gray-700">
        Role: <span class="font-semibold text-blue-600">student</span> | Approved: <span class="font-semibold text-green-600">Yes</span>
    </p>

    <form method="POST" action="{{ route('logout') }}" class="mt-4 inline-block">
        @csrf
        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">
            Logout
        </button>
    </form>

</div>
@endsection