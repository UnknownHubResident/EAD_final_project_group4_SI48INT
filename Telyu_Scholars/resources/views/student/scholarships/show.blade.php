@extends('layouts.student')

@section('content')
<div>
  <div class="bg-white rounded-lg overflow-hidden shadow">
    @if($scholarship->image)
      <img src="{{ asset('storage/'.$scholarship->image) }}" class="w-full h-64 object-cover">
    @endif

    <div class="p-6">
      <h1 class="text-3xl font-bold">{{ $scholarship->title }}</h1>
      <p class="text-gray-600 mt-2">Provider: {{ $scholarship->provider ?? '—' }}</p>
      <p class="text-red-600 mt-1">Deadline: {{ $scholarship->deadline->format('d M Y') }}</p>

      <div class="mt-6 prose">
        {!! nl2br(e($scholarship->description)) !!}
      </div>
    </div>
  </div>
</div>
@endsection
