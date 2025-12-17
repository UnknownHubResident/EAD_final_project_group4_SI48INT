@extends('layouts.provider')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Review Application</h1>
        <a href="{{ route('provider.applications.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            &larr; Back to Applications List
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-xl p-6 space-y-8">
        {{-- Application Status & Actions --}}
        <div class="border-b pb-4">
            <h2 class="text-xl font-semibold mb-2">Application Status</h2>

            @php
                $status = $application->status;
                $statusClass = [
                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-500',
                    'approved' => 'bg-green-100 text-green-800 border-green-500',
                    'rejected' => 'bg-red-100 text-red-800 border-red-500',
                ][$status] ?? 'bg-gray-100 text-gray-800 border-gray-500';
            @endphp

            <div class="flex items-center justify-between p-4 border-l-4 {{ $statusClass }} rounded-r-lg">
                <span class="text-lg font-bold">{{ ucfirst($status) }}</span>
                
                {{-- Actions (Only for Pending status) --}}
                @if ($status === 'pending')
                    <div class="space-x-3">
                        {{-- Approve Button --}}
                        <form action="{{ route('provider.applications.approve', $application) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Are you sure you want to approve this application?')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150">
                                Approve Application
                            </button>
                        </form>
                        
                        {{-- Reject Button (Redirects to form) --}}
                        <a href="{{ route('provider.applications.reject.form', $application) }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150">
                            Reject Application
                        </a>
                    </div>
                @endif
            </div>

            @if ($status === 'rejected' && $application->rejection_reason)
                <div class="mt-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
                    <strong>Rejection Reason:</strong> {{ $application->rejection_reason }}
                </div>
            @endif
        </div>

        {{-- Application Details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
            {{-- Column 1: Applicant Info --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold border-b pb-1 text-indigo-700">Applicant & Scholarship Info</h3>
                <p><strong>Applicant Name:</strong> {{ $application->user->name }}</p>
                <p><strong>Applied For Scholarship:</strong> {{ $application->scholarship->title }}</p>
                <p><strong>Student ID:</strong> {{ $application->student_number }}</p>
                <p><strong>Application Date:</strong> {{ $application->created_at->format('d M Y H:i') }}</p>
            </div>

            {{-- Column 2: Academic Info --}}
            <div class="space-y-4">
                <h3 class="text-lg font-semibold border-b pb-1 text-indigo-700">Academic Information</h3>
                <p><strong>Study Major:</strong> {{ $application->study_major }}</p>
                <p><strong>Year/Batch:</strong> {{ $application->year_batch }}</p>
                <p><strong>Degree Rank (GPA):</strong> {{ $application->degree_rank }}</p>
                <p><strong>Scholarship Amount:</strong> ${{ number_format($application->scholarship->amount) }}</p>
            </div>
        </div>

        {{-- Document Downloads --}}
        <div class="pt-6 border-t">
            <h3 class="text-lg font-semibold mb-3 text-indigo-700">Supporting Documents</h3>
            <div class="flex space-x-6">
                {{-- Transcript Download --}}
                <a href="{{ route('provider.applications.download', ['application' => $application, 'documentType' => 'transcript']) }}"
                   class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 bg-white hover:bg-blue-50 font-medium rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 11.586V4a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    Download Transcript
                </a>
                
                {{-- Student ID Download --}}
                <a href="{{ route('provider.applications.download', ['application' => $application, 'documentType' => 'student_id']) }}"
                   class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 bg-white hover:bg-blue-50 font-medium rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2V7a5 5 0 00-5-5zM7 7a3 3 0 016 0v2H7V7z"/></svg>
                    Download Student ID
                </a>
            </div>
        </div>

        {{-- Motivation Letter --}}
        <div class="pt-6 border-t">
    <h3 class="text-lg font-semibold mb-3 text-indigo-700">Motivation Letter</h3>
    <div class="p-4 bg-gray-50 border rounded-lg">
        <a href="{{ route('provider.applications.download', ['application' => $application, 'documentType' => 'motivation_letter']) }}"
           class="inline-flex items-center px-4 py-2 border border-indigo-600 text-indigo-600 bg-white hover:bg-indigo-50 font-medium rounded-lg shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h2a2 2 0 002-2V4a2 2 0 00-2-2H9z" />
                <path fill-rule="evenodd" d="M4 11a2 2 0 012-2h10a2 2 0 012 2v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5zm2 1a1 1 0 00-1 1v3a1 1 0 001 1h10a1 1 0 001-1v-3a1 1 0 00-1-1H6z" clip-rule="evenodd" />
            </svg>
            Download Motivation Letter (PDF)
        </a>
    </div>
</div>
    </div>
</div>
@endsection
