@extends('layouts.student')

@section('content')
<div>
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Scholarship Directory</h1>
    <form method="GET" class="flex items-center space-x-2">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title..."
             class="px-3 py-2 border rounded">
      <button class="px-3 py-2 bg-blue-600 text-white rounded">Search</button>
    </form>
  </div>

  <div class="grid gap-6 grid-cols-1 md:grid-cols-3">
    @forelse($scholarships as $s)
      <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($s->image)
          <img src="{{ asset('storage/'.$s->image) }}" class="h-44 w-full object-cover">
        @else
          <div class="h-44 bg-gray-200 flex items-center justify-center text-gray-500">No image</div>
        @endif

        <div class="p-4">
          <h2 class="font-bold text-lg">{{ $s->title }}</h2>
          <p class="text-sm text-gray-600">{{ Str::limit($s->description, 120) }}</p>
          <div class="mt-3 flex justify-between items-center">
            <span class="text-sm text-red-600">Deadline: {{ $s->deadline->format('d M Y') }}</span>
            <a href="{{ route('student.scholarships.show', $s) }}"
               class="px-3 py-1 bg-red-600 text-white rounded">View</a>
          </div>
        </div>
      </div>
    @empty
      <p>No scholarships found.</p>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $scholarships->links() }}
  </div>
</div>
@endsection
