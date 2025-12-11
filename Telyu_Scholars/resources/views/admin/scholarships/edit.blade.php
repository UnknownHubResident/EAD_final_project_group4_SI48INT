@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Scholarship</h1>

<form action="{{ route('admin.scholarships.update', $scholarship) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
  @csrf
  @method('PUT')

  <div class="mb-4">
    <label class="font-semibold">Title</label>
    <input type="text" name="title" class="w-full border p-2 rounded" value="{{ old('title', $scholarship->title) }}">
  </div>

  <div class="mb-4">
    <label class="font-semibold">Provider</label>
    <input type="text" name="provider" class="w-full border p-2 rounded" value="{{ old('provider', $scholarship->provider) }}">
  </div>

  <div class="mb-4">
    <label class="font-semibold">Description</label>
    <textarea name="description" class="w-full border p-2 rounded h-32">{{ old('description', $scholarship->description) }}</textarea>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="font-semibold">Amount</label>
      <input type="number" name="amount" step="0.01" class="w-full border p-2 rounded" value="{{ old('amount', $scholarship->amount) }}">
    </div>

    <div>
      <label class="font-semibold">Deadline</label>
      <input type="date" name="deadline" class="w-full border p-2 rounded" value="{{ old('deadline', $scholarship->deadline->format('Y-m-d')) }}">
    </div>
  </div>

  <div class="mb-4 mt-4">
    <label class="font-semibold">Image (optional)</label>
    @if($scholarship->image)
      <div class="mb-2"><img src="{{ asset('storage/'.$scholarship->image) }}" class="h-20 rounded"></div>
      <div class="mb-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="delete_image" value="1" class="form-checkbox text-red-600">
                    <span class="ml-2 text-red-600 font-semibold">Check to delete current image</span>
                </label>
            </div>
    @endif
    <input type="file" name="image" accept="image/*" class="w-full">
  </div>

  <div>
    <label class="inline-flex items-center">
      <input type="checkbox" name="is_active" value="1" {{ $scholarship->is_active ? 'checked' : '' }} class="mr-2">
      <span>Active</span>
    </label>
  </div>

  <div class="mt-4">
    <button class="px-4 py-2 bg-yellow-500 text-white rounded">Update</button>
  </div>
</form>
@endsection
