@extends('layouts.student')

@section('content')
<h1 class="text-3xl font-bold mb-6">Scholarship Directory</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @foreach($scholarships as $scholarship)
    <div class="bg-white rounded-lg overflow-hidden shadow">

        @if($scholarship->image)
            <img src="{{ asset('storage/'.$scholarship->image) }}" class="w-full h-64 object-cover">
        @else
            <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500">
                No Image
            </div>
        @endif

        <div class="p-4">
            <h2 class="text-xl font-bold">{{ $scholarship->title }}</h2>

            <p class="text-gray-600">
                Deadline: {{ $scholarship->deadline->format('d M Y') }}
            </p>

            <a href="{{ route('student.scholarships.show', $scholarship) }}"
               class="mt-4 inline-block px-4 py-2 bg-red-600 text-white rounded">
                View Details
            </a>
        </div>

    </div>
    @endforeach

</div>

@endsection
