@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Applications</h2>

    @if($applications->isEmpty())
        <p class="text-gray-600">
            No applications yet. 
            <a href="{{ route('application.create') }}" class="text-red-600 font-semibold hover:underline">Apply now</a>
        </p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($applications as $app)
                <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">
                        {{ $app->scholarship->name ?? 'N/A' }}
                    </h3>

                    <div class="mb-3">
                        @if($app->status === 'pending')
                            <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">Pending</span>
                        @elseif($app->status === 'approved')
                            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Approved</span>
                        @else
                            <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">Rejected</span>
                        @endif
                    </div>

                    <p class="text-gray-600 text-sm mb-1">
                        Documents: <span class="font-medium">{{ $app->documents->count() }} file{{ $app->documents->count() != 1 ? 's' : '' }}</span>
                    </p>

                    <p class="text-gray-600 text-sm mb-3">
                        Submitted: <span class="font-medium">{{ $app->created_at->format('d M Y') }}</span>
                    </p>

                    @if($app->remarks)
                        <p class="text-gray-700 text-sm italic bg-gray-50 p-2 rounded border border-gray-100">
                            Remarks: {{ $app->remarks }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
