@extends('layouts.provider')

@section('content')
<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6">Create Scholarship</h1>

    <form action="{{ route('provider.scholarships.store') }}" method="POST"
        enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label class="font-semibold">Title</label>
            <input type="text" name="title"
                   class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-200">
            @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="font-semibold">Description</label>
            <textarea name="description"
                      class="w-full mt-1 p-3 border rounded-lg h-32 focus:ring focus:ring-blue-200"></textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="font-semibold">Amount (in IDR/rupiah)</label>
            <input type="number" name="amount"
                   class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-200">
            @error('amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="font-semibold">Deadline</label>
            <input type="date" name="deadline"
                   class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-200">
            @error('deadline')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="font-semibold">Image</label>
            <input type="file" name="image" id="image"
                class="w-full mt-1 p-3 border rounded-lg focus:ring focus:ring-blue-200">
            @error('image')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
            Create
        </button>
    </form>
</div>
@endsection
