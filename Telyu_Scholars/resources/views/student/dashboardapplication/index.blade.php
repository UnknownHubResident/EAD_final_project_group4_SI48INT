@extends('layouts.student')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- 1. Header Section --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">My Application Dashboard</h1>
        <p class="mt-2 text-sm text-gray-600">Track the status of your scholarship applications and review feedback.</p>
    </div>

    {{-- 2. Notifications --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- 3. Application List --}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md border border-gray-200">
        @if ($applications->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No applications</h3>
                <p class="mt-1 text-sm text-gray-500">You haven't submitted any scholarship applications yet.</p>
                <div class="mt-6">
                    <a href="{{ route('student.scholarships.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                        Browse Scholarships
                    </a>
                </div>
            </div>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach ($applications as $application)
                    <li class="p-6">
                        <div class="flex items-center justify-between flex-wrap sm:flex-nowrap">
                            {{-- Scholarship Info --}}
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">
                                    {{ $application->scholarship->title }}
                                </h3>
                                <div class="flex flex-col text-sm text-gray-500 space-y-1">
                                    <span><strong>Submitted:</strong> {{ $application->created_at->format('M d, Y') }}</span>
                                    <span><strong>Provider:</strong> {{ $application->scholarship->provider->name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            {{-- Status and Actions --}}
                            <div class="mt-4 sm:mt-0 sm:ml-6 flex items-center space-x-4">
                                @php
                                    $statusClasses = match($application->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                        'approved' => 'bg-green-100 text-green-800 border-green-300',
                                        'rejected' => 'bg-red-100 text-red-800 border-red-300',
                                        default => 'bg-gray-100 text-gray-800 border-gray-300',
                                    };
                                @endphp

                                <span class="px-3 py-1 text-xs font-bold uppercase rounded-full border {{ $statusClasses }}">
                                    {{ $application->status }}
                                </span>

                                @if ($application->status === 'rejected' && $application->rejection_reason)
                                    <button 
                                        type="button"
                                        onclick="document.getElementById('reason-{{ $application->id }}').classList.toggle('hidden')"
                                        class="text-sm font-semibold text-red-600 hover:text-red-800 underline focus:outline-none">
                                        View Reason
                                    </button>
                                @endif
                            </div>
                        </div>

                        {{-- Hidden Rejection Reason Box --}}
                        @if ($application->status === 'rejected' && $application->rejection_reason)
                            <div id="reason-{{ $application->id }}" class="hidden mt-4">
                                <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-inner">
                                    <p class="text-xs font-bold text-red-700 uppercase tracking-wider mb-1">Reason for Rejection</p>
                                    <p class="text-gray-700 text-sm leading-relaxed italic">
                                        "{{ $application->rejection_reason }}"
                                    </p>
                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection