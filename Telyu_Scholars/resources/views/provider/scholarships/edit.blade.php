@extends('layouts.provider')

@section('content')
<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6">Edit Scholarship</h1>

    <form action="{{ route('provider.scholarships.update', $scholarship) }}" method="POST"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="font-semibold">Title</label>
            <input type="text" name="title" value="{{ $scholarship->title }}"
                   class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label class="font-semibold">Description</label>
            <textarea name="description"
                      class="w-full mt-1 p-3 border rounded-lg h-32 focus:ring focus:ring-blue-200">{{ $scholarship->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Amount</label>
            <input type="number" name="amount" value="{{ $scholarship->amount }}"
                   class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-200">
        </div>

        <div class="mb-4">
            <label class="font-semibold">Deadline</label>
            <input type="date" name="deadline"
                   value="{{ $scholarship->deadline->format('Y-m-d') }}"
                   class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-200">
        </div>

       <div class="mb-4">
            <label for="image" class="font-semibold">Current Image</label>
            @if ($scholarship->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $scholarship->image) }}" alt="Current Scholarship Image" class="w-32 h-32 object-cover rounded-lg">
                </div>
                
               
                <div class="mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="delete_image" value="1" class="form-checkbox text-red-600">
                        <span class="ml-2 text-red-600 font-semibold">Check to delete current image</span>
                    </label>
                </div>
            @else
                <p class="text-gray-500">No image currently set.</p>
            @endif

            <label for="image" class="font-semibold mt-2 block">Upload New Image (Optional)</label>
            <input type="file" name="image" id="image"
                class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-200">
            @error('image')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4 flex items-center space-x-4">
        
        <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow">
            Update
        </button>
    </form> 
    <form action="{{ route('provider.scholarships.destroy', $scholarship) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this scholarship? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">
            Delete
        </button>
    </form>
</div>
@endsection
