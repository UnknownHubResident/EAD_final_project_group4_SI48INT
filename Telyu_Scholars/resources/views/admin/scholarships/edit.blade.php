@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    {{-- Header Section with Dynamic Back Button --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Scholarship</h1>
        
        @php
            $prefix = Auth::user()->role === 'admin' ? 'admin' : 'provider';
        @endphp

        <a href="{{ route($prefix . '.scholarships.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to List
        </a>
    </div>

    {{-- Main Form Card --}}
    <form action="{{ route($prefix . '.scholarships.update', $scholarship) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-md border border-gray-200">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            {{-- Title --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Scholarship Title</label>
                <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border @error('title') border-red-500 @enderror" value="{{ old('title', $scholarship->title) }}" required>
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-blue-50 p-3 rounded-md border border-blue-100 mt-4">
    <label class="block text-xs font-bold text-blue-600 uppercase tracking-wide">Scholarship Owner / Provider</label>
    <p class="text-gray-800 font-medium">
        {{ $scholarship->provider->name ?? 'System Admin' }} 
        <span class="text-gray-500 text-sm font-normal">({{ $scholarship->provider->email ?? 'N/A' }})</span>
    </p>
</div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="5" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border @error('description') border-red-500 @enderror" required>{{ old('description', $scholarship->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Amount and Deadline --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Amount (in IDR/rupiah)</label>
                    <input type="number" name="amount" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border @error('amount') border-red-500 @enderror" value="{{ old('amount', $scholarship->amount) }}" required>
                    @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deadline</label>
                    <input type="date" name="deadline" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border @error('deadline') border-red-500 @enderror" value="{{ old('deadline', $scholarship->deadline ? $scholarship->deadline->format('Y-m-d') : '') }}" required>
                    @error('deadline') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Image Management Section --}}
            <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Scholarship Cover Image</label>
                
                @if($scholarship->image)
                    <div class="mb-4 flex items-start space-x-4">
                        <div class="relative">
                            <img src="{{ asset('storage/'.$scholarship->image) }}" class="h-24 w-32 object-cover rounded shadow-sm border border-gray-300">
                        </div>
                        <div class="flex flex-col space-y-2">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="delete_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <span class="ml-2 text-sm text-red-600 font-medium">Remove current image</span>
                            </label>
                            <p class="text-xs text-gray-500 italic">Check this if you want to remove the image without uploading a new one.</p>
                        </div>
                    </div>
                @endif

                <div class="mt-2">
                    <input type="file" name="image" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    <p class="text-xs text-gray-400 mt-2">Recommended: 800x400px. Max size 2MB.</p>
                </div>
            </div>

            {{-- Status Checkbox (The Activation Fix) --}}
            <div class="py-4 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700">Visibility Status</h3>
                        <p class="text-xs text-gray-500">Enable or disable this scholarship from student listings.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $scholarship->is_active ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        <span class="ml-3 text-sm font-bold {{ $scholarship->is_active ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $scholarship->is_active ? 'ACTIVE' : 'INACTIVE' }}
                        </span>
                    </label>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md transition-all duration-200 focus:ring-4 focus:ring-indigo-200">
                    Update Scholarship
                </button>
            </div>
        </div>
    </form>
</div>
@endsection