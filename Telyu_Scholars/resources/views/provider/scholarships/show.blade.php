@extends('layouts.provider')

@section('content')
<div class="max-w-4xl mx-auto py-10">

    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $scholarship->title }}</h1>

        <p class="text-gray-700"><strong>Description:</strong></p>
        <p class="mb-3 text-gray-800">{{ $scholarship->description }}</p>

        <p class="text-gray-700"><strong>Amount:</strong> Rp {{ number_format($scholarship->amount) }}</p>
        <p class="text-gray-700"><strong>Deadline:</strong> {{ $scholarship->deadline->format('Y-m-d') }}</p>
        <p class="text-gray-700"><strong>Status:</strong>
            <span class="px-2 py-1 rounded {{ $scholarship->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                {{ $scholarship->is_active ? 'Active' : 'Inactive' }}
            </span>
        </p>

        <a href="{{ route('provider.scholarships.edit', $scholarship) }}"
           class="mt-4 inline-block px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg">
            Edit
        </a>
    </div>

</div>
@endsection
