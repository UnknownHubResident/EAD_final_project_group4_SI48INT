@extends('layouts.provider')

@section('content')
{{-- 1. THIS KILLS THE RED SIDES --}}
<div class="fixed inset-0 bg-white -z-50"></div>

{{-- 2. MAIN CONTENT CONTAINER --}}
<div class="relative min-h-screen bg-white pb-20">
    
    <div class="max-w-screen-2xl mx-auto px-10 pt-12">
        
        <h1 class="text-6xl font-black text-black tracking-tighter mb-12">
            Scholarship Directory
        </h1>

        <div class="mb-16">
            <form method="GET" action="{{ route('provider.scholarships.index') }}" class="flex flex-wrap items-center gap-10">
                <div class="flex items-center gap-5">
                    <label class="text-xl font-bold text-gray-700">Search</label>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search scholarship..."
                        value="{{ request('search') }}"
                        class="border border-gray-300 rounded-xl px-6 py-4 text-xl w-96 focus:outline-none focus:ring-2 focus:ring-[#c5443a] bg-white shadow-sm"
                    >
                </div>

                <div class="flex items-center gap-5">
                    <label class="text-xl font-bold text-gray-700">Sort Deadline</label>
                    <select name="sort_deadline" class="border border-gray-300 rounded-xl px-6 py-4 text-xl focus:outline-none focus:ring-2 focus:ring-[#c5443a] bg-white shadow-sm">
                        <option value="">Default</option>
                        <option value="asc" @selected(request('sort_deadline')==='asc')>Nearest</option>
                        <option value="desc" @selected(request('sort_deadline')==='desc')>Farthest</option>
                    </select>
                </div>

                <button type="submit" class="bg-[#c5443a] hover:bg-[#a33830] text-white px-10 py-4 rounded-xl text-xl font-extrabold transition-all shadow-md active:scale-95">
                    Apply Filter
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-14">
            @forelse($scholarships as $s)
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-200 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col">
                    
                    {{-- Image: No text overlaps this --}}
                    <div class="h-80 bg-gray-100 relative">
                        @if($s->image)
                            <img src="{{ asset('storage/'.$s->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-10 flex flex-col flex-grow">
                        <h2 class="text-3xl font-black text-gray-900 mb-4 leading-tight">{{ $s->title }}</h2>
                        <p class="text-xl text-gray-600 line-clamp-3 mb-8 leading-relaxed">{{ $s->description }}</p>

                        <div class="space-y-4 mb-10">
                            {{-- Eligibility and Funding --}}
                            <div class="flex flex-wrap gap-3">
                                <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl">
                                    <p class="text-xs uppercase tracking-widest text-gray-400 font-black mb-1">Eligibility</p>
                                    <p class="text-xl font-bold text-gray-800">All Majors</p>
                                </div>
                                
                                <div class="bg-green-50 border border-green-100 p-4 rounded-2xl">
                                    <p class="text-xs uppercase tracking-widest text-green-600 font-black mb-1">Funding</p>
                                    <p class="text-xl font-bold text-green-700">IDR {{ number_format($s->amount, 0) }}</p>
                                </div>
                            </div>

                            <p class="text-2xl text-[#c5443a] font-black mt-6 block">
                                📅 Deadline: {{ $s->deadline->format('d M Y') }}
                            </p>
                        </div>

                        <a href="{{ route('provider.scholarships.edit', $s) }}"
                           class="mt-auto block text-center bg-[#c5443a] text-white px-8 py-5 rounded-2xl text-xl font-black hover:bg-[#a33830] transition-all shadow-xl">
                            Edit Scholarship
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-32 bg-white rounded-[3rem] border-2 border-dashed border-gray-300 shadow-sm">
                    <p class="text-3xl text-gray-400 font-bold tracking-tight">No scholarships found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-20 scale-150 origin-center">
            {{ $scholarships->links() }}
        </div>
    </div>
</div>
@endsection