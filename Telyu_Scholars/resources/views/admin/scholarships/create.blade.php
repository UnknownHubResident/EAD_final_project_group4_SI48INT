@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-4">Create Scholarship</h1>

{{-- 🔴 WRAPPER PENTING --}}
<div class="relative z-0 pointer-events-auto">

    <form action="{{ route('admin.scholarships.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow">

        @csrf

        {{-- TITLE --}}
        <div class="mb-4">
            <label class="font-semibold">Title</label>
            <input type="text" name="title"
                   class="w-full border p-2 rounded"
                   value="{{ old('title') }}">
        </div>

        {{-- DESCRIPTION --}}
        <div class="mb-4">
            <label class="font-semibold">Description</label>
            <textarea name="description"
                      class="w-full border p-2 rounded h-32">{{ old('description') }}</textarea>
        </div>

        {{-- AMOUNT & DEADLINE --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-semibold">Amount</label>
                <input type="number" name="amount"
                       class="w-full border p-2 rounded"
                       value="{{ old('amount') }}">
            </div>

            <div>
                <label class="font-semibold">Deadline</label>
                <input type="date" name="deadline"
                       class="w-full border p-2 rounded"
                       value="{{ old('deadline') }}">
            </div>
        </div>

        {{-- IMAGE --}}
        <div class="mt-4">
            <label class="font-semibold">Image</label>
            <input type="file" name="image" class="w-full">
        </div>

        {{-- ACTIVE --}}
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" checked>
                <span class="ml-2">Active</span>
            </label>
        </div>

        {{-- MAJORS --}}
        <div class="mt-4">
            <label class="block font-semibold mb-2">Eligible Majors</label>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($majors as $major)
                    <label class="flex items-center space-x-2 text-sm">
                        <input type="checkbox"
                               name="majors[]"
                               value="{{ $major->id }}">
                        <span>{{ $major->name }}</span>
                    </label>
                @endforeach
            </div>

            <p class="text-xs text-gray-500 mt-1">
                Leave empty if open for all majors
            </p>
        </div>

        {{-- SUBMIT --}}
        <button class="mt-6 bg-blue-600 text-white px-6 py-2 rounded">
            Create
        </button>

    </form>

</div>
@endsection
