@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create Scholarship</h1>

<form action="{{ route('provider.scholarships.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
  @csrf

  <div class="mb-4">
    <label class="font-semibold">Title</label>
    <input type="text" name="title" class="w-full border p-2 rounded" value="{{ old('title') }}">
    @error('title') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
  </div>

  <div class="mb-4">
    <label class="font-semibold">Provider</label>
    <input type="text" name="provider" class="w-full border p-2 rounded" value="{{ old('provider') }}">
    @error('provider') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
  </div>

  <div class="mb-4">
    <label class="font-semibold">Description</label>
    <textarea name="description" class="w-full border p-2 rounded h-32">{{ old('description') }}</textarea>
    @error('description') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="font-semibold">Amount</label>
      <input type="number" name="amount" step="0.01" class="w-full border p-2 rounded" value="{{ old('amount') }}">
      @error('amount') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>

    <div>
      <label class="font-semibold">Deadline</label>
      <input type="date" name="deadline" class="w-full border p-2 rounded" value="{{ old('deadline') }}">
      @error('deadline') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
    </div>
  </div>

  <div class="mb-4 mt-4">
    <label class="font-semibold">Image (optional)</label>
    <input type="file" name="image" accept="image/*" class="w-full">
    @error('image') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
  </div>

  <div>
    <label class="inline-flex items-center">
      <input type="checkbox" name="is_active" value="1" checked class="mr-2">
      <span>Active</span>
    </label>
  </div>

  <div class="mt-4">
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
  </div>
</form>
@endsection
