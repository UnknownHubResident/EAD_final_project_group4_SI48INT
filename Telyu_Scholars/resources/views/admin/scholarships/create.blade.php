@extends('layouts.admin')

@section('content')
{{-- 1. Force full-screen white background --}}
<div class="fixed inset-0 bg-white -z-50"></div>

<div class="relative min-h-screen bg-white pb-20">
    <div class="max-w-4xl mx-auto px-10 pt-12">
        
        {{-- Header: Same as Directory style --}}
        <div class="flex items-center justify-between mb-12">
            <h1 class="text-6xl font-black text-black tracking-tighter">
                Create Scholarship
            </h1>
            <a href="{{ route('admin.scholarships.index') }}" class="text-xl font-bold text-gray-400 hover:text-[#c5443a] transition-colors">
                ← Back
            </a>
        </div>

        {{-- Main Form Card: Same rounded style as the Scholarship Cards --}}
        <form action="{{ route('admin.scholarships.store') }}" method="POST" enctype="multipart/form-data" 
              class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 p-12 space-y-10">
            @csrf

            {{-- 1. PROVIDER INFO (Static) --}}
            <div class="space-y-4">
                <p class="text-sm uppercase tracking-widest text-gray-400 font-black">Official Provider</p>
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <p class="text-2xl font-black text-gray-800">Telkom University Student Affairs Relation</p>
                </div>
            </div>

            {{-- 2. TITLE --}}
            <div class="space-y-4">
                <label class="text-xl font-bold text-gray-700">Scholarship Title</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter title..."
                    class="w-full border border-gray-300 rounded-xl px-6 py-4 text-xl focus:outline-none focus:ring-2 focus:ring-[#c5443a] bg-white shadow-sm @error('title') border-red-500 @enderror" required>
                @error('title') <p class="text-[#c5443a] font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 3. DESCRIPTION --}}
            <div class="space-y-4">
                <label class="text-xl font-bold text-gray-700">Description</label>
                <textarea name="description" rows="5" placeholder="Details about the scholarship..."
                    class="w-full border border-gray-300 rounded-xl px-6 py-4 text-xl focus:outline-none focus:ring-2 focus:ring-[#c5443a] bg-white shadow-sm" required>{{ old('description') }}</textarea>
            </div>

            {{-- 4. AMOUNT & DEADLINE --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="text-xl font-bold text-gray-700">Amount (IDR)</label>
                    <input type="number" name="amount" step="0.01" value="{{ old('amount') }}" placeholder="e.g. 5000000"
                        class="w-full border border-gray-300 rounded-xl px-6 py-4 text-xl focus:outline-none focus:ring-2 focus:ring-[#c5443a] bg-white shadow-sm">
                </div>
                <div class="space-y-4">
                    <label class="text-xl font-bold text-gray-700">Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}"
                        class="w-full border border-gray-300 rounded-xl px-6 py-4 text-xl focus:outline-none focus:ring-2 focus:ring-[#c5443a] bg-white shadow-sm">
                </div>
            </div>

            {{-- 5. MAJORS --}}
            <div class="space-y-6">
                <p class="text-sm uppercase tracking-widest text-gray-400 font-black">Eligible Majors</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 bg-gray-50 p-8 rounded-[2rem] border border-gray-100">
                    @foreach($majors as $major)
                        <label class="flex items-center space-x-4 cursor-pointer group">
                            <input type="checkbox" name="majors[]" value="{{ $major->id }}" 
                                   class="w-6 h-6 rounded border-gray-300 text-[#c5443a] focus:ring-[#c5443a]">
                            <span class="text-xl font-bold text-gray-600 group-hover:text-black transition-colors">{{ $major->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- 6. IMAGE --}}
            <div class="space-y-4">
                <label class="text-xl font-bold text-gray-700">Cover Image</label>
                <div class="bg-white border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center">
                    <input type="file" name="image" accept="image/*" class="text-xl text-gray-500 file:mr-6 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xl file:font-black file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                </div>
            </div>

            {{-- 7. SUBMIT BUTTON: Same Red as Provider Edit button --}}
            <div class="pt-10">
                <button type="submit" class="w-full bg-[#c5443a] hover:bg-[#a33830] text-white px-10 py-6 rounded-2xl text-2xl font-black transition-all shadow-xl active:scale-95">
                    Create Scholarship
                </button>
            </div>
        </form>
    </div>
</div>
@endsection