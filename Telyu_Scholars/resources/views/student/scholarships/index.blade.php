@extends('layouts.student')

@section('content')
<h1 class="text-3xl font-bold mb-6">Scholarship Directory</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($scholarships as $scholarship)
    <div class="relative bg-white rounded-lg overflow-hidden shadow-md transition-all border {{ !$scholarship->is_active ? 'grayscale opacity-75' : 'hover:shadow-xl' }}">
        
        {{-- Inactive Overlay Badge --}}
        @if(!$scholarship->is_active)
            <div class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none bg-white bg-opacity-10">
                <span class="bg-gray-800 text-white px-4 py-2 rounded-full font-bold uppercase tracking-widest text-xs shadow-2xl">
                    Currently Closed
                </span>
            </div>
        @endif

        {{-- Image Section --}}
        @if($scholarship->image)
            <img src="{{ asset('storage/'.$scholarship->image) }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif

        <div class="p-6">
            <h3 class="text-xl font-bold {{ !$scholarship->is_active ? 'text-gray-500' : 'text-indigo-600' }}">
                {{ $scholarship->title }}
            </h3>
            
            <p class="mt-2 text-gray-600 text-sm line-clamp-2">{{ Str::limit($scholarship->description, 100) }}</p>

            <div class="mt-4 flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-lg text-gray-800">{{ $scholarship->formatted_amount }}</span>
                    <span class="text-xs text-gray-500 italic">Deadline: {{ $scholarship->deadline->format('d M Y') }}</span>
                </div>
                
                @if($scholarship->is_active)
                    <a href="{{ route('student.scholarships.show', $scholarship) }}" 
                       class="w-full text-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition font-semibold">
                        View Details
                    </a>
                @else
                    <button disabled class="w-full bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed font-semibold">
                        Closed
                    </button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination Links --}}
<div class="mt-8">
    {{ $scholarships->links() }}
</div>

@endsection