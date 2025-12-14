@extends('layouts.student')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <h1 class="text-3xl font-bold mb-6">Scholarship Directory</h1>

    <!-- 🔍 FILTER SECTION -->
    <form method="GET" class="mb-8 flex flex-wrap gap-4 items-end">

        <div>
            <label class="text-sm font-medium">Search</label>
            <input
                type="text"
                name="search"
                placeholder="Search scholarship..."
                value="{{ request('search') }}"
                class="border px-4 py-2 rounded w-full md:w-64"
            >
        </div>

        <div>
            <form method="GET" class="mb-4">
            <label class="text-sm font-medium">Sort Deadline</label>
            <select name="sort_deadline" class="border px-4 py-2 rounded">
                <option value="">Default</option>
                <option value="asc" @selected(request('sort_deadline')==='asc')>
                    Nearest
                </option>
                <option value="desc" @selected(request('sort_deadline')==='desc')>
                    Farthest
                </option>
            </select>
        </div>

        <div>
            <label class="text-sm font-medium">Filter Major</label>
            <select name="major" class="border rounded px-3 py-2">
            <option value="">All Majors</option>
            @foreach($majors as $major)
                <option value="{{ $major->id }}"
                    {{ request('major') == $major->id ? 'selected' : '' }}>
                    {{ $major->name }}
                </option>
            @endforeach
        </select>
        </div>

        <button class="px-6 py-2 bg-red-600 text-white rounded">
            Apply Filter
        </button>

    <!-- 📦 SCHOLARSHIP GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($scholarships as $scholarship)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                @if($scholarship->image)
                    <img src="{{ asset('storage/'.$scholarship->image) }}"
                         class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-gray-100 flex items-center justify-center text-gray-400">
                        No Image
                    </div>
                @endif

                <div class="p-5 space-y-3">
                    <h2 class="text-lg font-semibold">
                        {{ $scholarship->title }}
                    </h2>

                    <p class="text-sm text-gray-600 line-clamp-2">
                        {{ $scholarship->description }}
                    </p>

                    <p class="text-xs text-gray-500">
                        Eligible for:
                        <span class="font-medium">
                            {{ $scholarship->majors->pluck('name')->join(', ') ?: 'All Majors' }}
                        </span>
                    </p>

                    <p class="text-sm text-red-600 font-medium">
                        Deadline: {{ $scholarship->deadline->format('d M Y') }}
                    </p>

                    <a href="{{ route('student.scholarships.show', $scholarship) }}"
                       class="inline-block mt-2 bg-red-600 text-white px-4 py-2 rounded text-sm">
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-gray-500 text-center">
                No scholarships found.
            </p>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-8">
        {{ $scholarships->links() }}
    </div>

</div>
@endsection
