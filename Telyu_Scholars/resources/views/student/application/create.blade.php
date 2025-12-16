@extends('layouts.student')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('student.applications.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-red-600 mb-6">
        &larr; Back to My Applications
    </a>

    <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
        <div class="bg-red-600 px-6 py-4 text-white">
            <h4 class="text-xl font-bold">Apply for: {{ $scholarship->title }}</h4>
            <p class="text-sm opacity-90">Provider: {{ $scholarship->provider->name ?? 'N/A' }} | Deadline: {{ $scholarship->deadline->format('M d, Y') }}</p>
        </div>
        
        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('student.applications.store', $scholarship) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="border-b border-gray-200 pb-2">
                    <h5 class="text-lg font-semibold text-gray-800">Personal & Academic Details (Auto-filled)</h5>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Student Number</label>
                        <input type="text" name="student_number" value="{{ old('student_number', $defaultData['student_number']) }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Study Major</label>
                        <input type="text" name="study_major" value="{{ old('study_major', $defaultData['study_major']) }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Year/Batch</label>
                        <input type="text" name="year_batch" value="{{ old('year_batch', $defaultData['year_batch']) }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Degree Rank</label>
                        <input type="text" name="degree_rank" value="{{ old('degree_rank', $defaultData['degree_rank']) }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" required>
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-2 pt-4">
                    <h5 class="text-lg font-semibold text-gray-800">Application Documents</h5>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Motivation Letter (PDF)</label>
                        <input type="file" name="motivation_letter" accept="application/pdf" required
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Official Transcript (PDF)</label>
                        <input type="file" name="transcript" accept="application/pdf" required
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Student ID (JPG, PNG, PDF)</label>
                        <input type="file" name="student_id" accept=".jpg,.jpeg,.png,.pdf" required
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    </div>
                </div>
                
                <div class="pt-6">
                    <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition shadow-lg">
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection