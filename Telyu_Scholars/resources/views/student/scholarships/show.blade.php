@extends('layouts.student')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200">
        @if($scholarship->image)
            <div class="bg-gray-100 flex items-center justify-center border-b">
                <img src="{{ asset('storage/'.$scholarship->image) }}" class="max-h-[400px] w-auto object-contain">
            </div>
        @endif

        <div class="p-8">
            <h1 class="text-4xl font-extrabold text-gray-900">{{ $scholarship->title }}</h1>
            <p class="text-lg text-gray-600 mt-2">Provided by: <span class="font-semibold">{{ $scholarship->provider->name ?? 'N/A' }}</span></p>

           <div class="mt-4 p-4 bg-indigo-50 rounded-lg border border-indigo-100 inline-block">
                <span class="block text-sm font-semibold text-indigo-800 uppercase tracking-wider">Scholarship fund given:</span>
                <div class="text-3xl font-bold text-indigo-600">
                    {{ $scholarship->formatted_amount }}
                </div>
            </div>
            
            @php $is_open = now()->lt($scholarship->deadline); @endphp

            <div class="mt-4 flex items-center">
                @if ($is_open)
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold border border-green-200">
                        Open until {{ $scholarship->deadline->format('d M Y') }}
                    </span>
                @else
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-bold border border-red-200">
                        Closed on {{ $scholarship->deadline->format('d M Y') }}
                    </span>
                @endif
            </div>

            <div class="mt-8 text-gray-700 leading-relaxed text-lg whitespace-pre-line border-t pt-6">
                {!! nl2br(e($scholarship->description)) !!}
            </div>

            <div class="mt-10 pt-8 border-t flex justify-center">
                @if ($is_open)
                    <a href="{{ route('student.applications.create', $scholarship) }}" 
                       class="inline-block bg-red-600 text-white text-xl font-bold py-4 px-12 rounded-xl hover:bg-red-700 transition transform hover:scale-105 shadow-xl">
                        Apply Now
                    </a>
                @else
                    <div class="bg-gray-100 text-gray-500 font-bold py-4 px-8 rounded-xl border-2 border-dashed border-gray-300 w-full text-center">
                        Applications for this scholarship are now closed.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection