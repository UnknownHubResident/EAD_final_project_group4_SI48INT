@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
  <h1 class="text-2xl font-bold">Manage Scholarships</h1>
  <a href="{{ route('admin.scholarships.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Create</a>
</div>

<div class="bg-white shadow rounded">
  <table class="w-full text-left">
    <thead class="bg-gray-50">
      <tr>
        <th class="p-3">Image</th>
        <th class="p-3">Title</th>
        <th class="p-3">Deadline</th>
        <th class="p-3">Status</th>
        <th class="p-3">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($scholarships as $s)
      <tr class="border-t">
        <td class="p-3">
          @if($s->image)
            <img src="{{ asset('storage/'.$s->image) }}" class="h-12 rounded">
          @else
            <span class="text-gray-500">—</span>
          @endif
        </td>
        <td class="p-3">{{ $s->title }}</td>
        <td class="p-3">{{ $s->deadline->format('d M Y') }}</td>
        <td class="p-3">{{ $s->is_active ? 'Active' : 'Inactive' }}</td>
        <td class="p-3 space-x-2">
          <a href="{{ route('admin.scholarships.edit', $s) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>

          <form action="{{ route('admin.scholarships.destroy', $s) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button class="px-3 py-1 bg-red-600 text-white rounded" onclick="return confirm('Delete?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ $scholarships->links() }}
</div>
@endsection
