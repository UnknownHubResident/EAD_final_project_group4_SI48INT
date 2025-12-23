@extends('layouts.provider')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Reject Application: Confirmation</h1>
        <a href="{{ route('provider.applications.show', $application) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            &larr; Back to Application Review
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-xl p-6">
        <h2 class="text-xl font-semibold text-red-700 mb-4">You are about to reject the following application:</h2>

        <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
            <p><strong>Applicant:</strong> {{ $application->user->name }}</p>
            <p><strong>Scholarship:</strong> {{ $application->scholarship->title }}</p>
            <p class="mt-3 text-sm text-red-600 font-semibold">
                ⚠️ This action is permanent and will notify the student of the rejection.
            </p>
        </div>
        
       <form action="{{ route('provider.applications.reject', $application) }}" method="POST" class="space-y-6">
    @csrf
    
    <div>
        <label for="remarks" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
        <div class="mt-1">
            <textarea 
                name="remarks" 
                id="remarks" 
                rows="5" 
                class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md @error('remarks') border-red-500 @enderror" 
                placeholder="e.g., Application incomplete, GPA minimum not met..."
                required
            >{{ old('remarks') }}</textarea>
        </div>
        @error('remarks')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-2 text-sm text-gray-500">The reason will be visible to the student.</p>
    </div>
    
    <div class="flex justify-end space-x-3">
        <a href="{{ route('provider.applications.show', $application) }}" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
            Cancel
        </a>
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150">
            Finalize Rejection
        </button>
    </div>
</form>

    </div>
</div>
@endsection
