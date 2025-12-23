@extends('layouts.student')

@section('content')
<div class="max-w-screen-2xl mx-auto px-10 py-12">
    
    <h1 class="text-4xl font-extrabold mb-10 text-gray-900 tracking-tight">Scholarship Directory</h1>

    <div class="mb-12">
        <form method="GET" action="{{ route('student.scholarships.index') }}" class="flex flex-wrap items-center gap-8">
            <button type="submit" class="bg-[#c5443a] hover:bg-[#a33830] text-white px-8 py-3 rounded-lg text-lg font-bold transition-all shadow-md active:scale-95">
                Apply Filter
            </button>

            <div class="flex items-center gap-4">
                <label class="text-lg font-bold text-gray-700">Search</label>
                <input
                    type="text"
                    name="search"
                    placeholder="Search scholarship..."
                    value="{{ request('search') }}"
                    class="border border-gray-300 rounded-lg px-5 py-3 text-lg w-80 focus:outline-none focus:ring-2 focus:ring-red-500"
                >
            </div>

            <div class="flex items-center gap-4">
                <label class="text-lg font-bold text-gray-700">Sort Deadline</label>
                <select name="sort_deadline" class="border border-gray-300 rounded-lg px-5 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-red-500 bg-white">
                    <option value="">Default</option>
                    <option value="asc" @selected(request('sort_deadline')==='asc')>Nearest</option>
                    <option value="desc" @selected(request('sort_deadline')==='desc')>Farthest</option>
                </select>
            </div>

            <div class="flex items-center gap-4">
                <label class="text-lg font-bold text-gray-700">Filter Major</label>
                <select name="major" class="border border-gray-300 rounded-lg px-5 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-red-500 bg-white">
                    <option value="">All Majors</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}" {{ request('major') == $major->id ? 'selected' : '' }}>
                            {{ $major->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-[#c5443a] hover:bg-[#a33830] text-white px-8 py-3 rounded-lg text-lg font-bold transition-all shadow-md active:scale-95">
                Apply Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
        @forelse($scholarships as $scholarship)
            <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col">
                
                <div class="h-64 bg-gray-100 relative">
                    @if($scholarship->image)
                        <img src="{{ asset('storage/'.$scholarship->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    @endif
                </div>

                <div class="p-8 flex flex-col flex-grow">
                    <div class="mb-4">
                        <h2 class="text-2xl font-black text-gray-900 leading-tight">{{ $scholarship->title }}</h2>
                        <div class="mt-2 text-2xl font-extrabold text-green-600">
                             {{ $scholarship->formatted_amount }}
                        </div>
                    </div>

                    <p class="text-lg text-gray-600 line-clamp-3 mb-6 leading-relaxed">
                        {{ $scholarship->description }}
                    </p>

                    <div class="space-y-4 mb-8">
                        <div>
                            <p class="text-sm uppercase tracking-widest text-gray-500 font-bold mb-1">Eligible for:</p>
                            <p class="text-lg font-semibold text-gray-800 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                {{ $scholarship->majors->pluck('name')->join(', ') ?: 'All Majors' }}
                            </p>
                        </div>
                        
                        <div class="flex items-center text-xl text-red-600 font-black">
                            <span class="mr-2">📅</span> Deadline: {{ $scholarship->deadline->format('d M Y') }}
                        </div>
                    </div>

                    <a href="{{ route('student.scholarships.show', $scholarship) }}"
                       class="mt-auto block text-center bg-[#c5443a] text-white px-6 py-4 rounded-xl text-lg font-black hover:bg-[#a33830] transition-colors shadow-lg">
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                <p class="text-2xl text-gray-400 font-medium">No scholarships found.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-16 scale-125 origin-center">
        {{ $scholarships->links() }}
    </div>

</div>
@endsection