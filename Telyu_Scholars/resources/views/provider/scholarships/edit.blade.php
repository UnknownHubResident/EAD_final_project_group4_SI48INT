@extends('layouts.provider')

@section('content')
<div class="max-w-3xl mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6">Edit Scholarship</h1>

    <form action="{{ route('provider.scholarships.update', $scholarship) }}" method="POST"
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

        <button class="mt-4 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow">
            Update
        </button>
    </form>
</div>
@endsection
