@extends('layouts.provider')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Scholarship</h1>
        <a href="{{ route('provider.scholarships.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
            ← Back to My List
        </a>
    </div>

    {{-- Main Update Form --}}
    <form action="{{ route('provider.scholarships.update', $scholarship) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-md border border-gray-200 mb-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            {{-- Title --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Scholarship Title</label>
                <input type="text" name="title" value="{{ old('title', $scholarship->title) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border" required>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="5" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border" required>{{ old('description', $scholarship->description) }}</textarea>
            </div>

            {{-- Amount and Deadline --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Amount (in IDR/rupiah)</label>
                    <input type="number" name="amount" step="0.01" value="{{ old('amount', $scholarship->amount) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline', $scholarship->deadline->format('Y-m-d')) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border" required>
                </div>
            </div>

            
            <div class="py-4 border-t border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-700">Accepting Applications</h3>
                    <p class="text-xs text-gray-500">Uncheck this to "Gray Out" the scholarship for students.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ $scholarship->is_active ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                    <span class="ml-3 text-sm font-medium {{ $scholarship->is_active ? 'text-green-600' : 'text-gray-400' }}">
                        {{ $scholarship->is_active ? 'Status: Active' : 'Status: Inactive' }}
                    </span>
                </label>
            </div>

            {{-- Image Management --}}
            <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cover Image</label>
                @if($scholarship->image)
                    <div class="mb-4 flex items-start space-x-4">
                        <img src="{{ asset('storage/'.$scholarship->image) }}" class="h-24 w-32 object-cover rounded shadow-sm">
                        <label class="inline-flex items-center mt-2 cursor-pointer">
                            <input type="checkbox" name="delete_image" value="1" class="rounded border-gray-300 text-red-600">
                            <span class="ml-2 text-sm text-red-600 font-medium">Remove current image</span>
                        </label>
                    </div>
                @endif
                <input type="file" name="image" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div class="flex items-center space-x-3 pt-4">
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow">
                    Save Changes
                </button>
            </div>
        </div>
    </form>

    {{-- Separate Delete Form --}}
    <div class="p-6 bg-red-50 rounded-lg border border-red-100 flex items-center justify-between">
        <div>
            <h4 class="text-red-800 font-bold">Danger Zone</h4>
            <p class="text-red-600 text-sm">Deleting this scholarship will remove all student applications associated with it.</p>
        </div>
        <form action="{{ route('provider.scholarships.destroy', $scholarship) }}" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold shadow transition">
                Delete Permanently
            </button>
        </form>
    </div>
</div>
@endsection