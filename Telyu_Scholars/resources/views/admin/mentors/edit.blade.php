@extends('layouts.admin')

@section('content')
<div class="bg-gray-100 min-h-screen p-6">
    <div class="bg-red-900 text-white p-4 rounded-t-lg flex justify-between items-center">
        <h1 class="text-xl font-bold tracking-wide">admin PANEL</h1>
        <span class="font-semibold text-sm">test user1 ∨</span>
    </div>

    <div class="bg-white p-6 rounded-b-lg shadow border border-gray-200 max-w-4xl mx-auto mt-2">
        <a href="{{ route('admin.mentors.index') }}" class="text-gray-500 hover:text-gray-800 text-xs font-bold uppercase tracking-wider flex items-center mb-6 transition">
            ← back to mentor management
        </a>
        
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3 tracking-tight">edit counselor/mentor details</h2>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded-r text-xs">
                <p class="font-bold">Please correct the following errors:</p>
                <ul class="list-disc pl-4 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.mentors.update', $mentor->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">counselor name</label>
                    <input type="text" name="name" value="{{ old('name', $mentor->name) }}" class="w-full border border-gray-300 rounded p-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">mentorship platform</label>
                    <select name="platform" class="w-full border border-gray-300 rounded p-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none bg-white" required>
                        <option value="onsite" {{ old('platform', $mentor->platform) == 'onsite' ? 'selected' : '' }}>onsite</option>
                        <option value="online" {{ old('platform', $mentor->platform) == 'online' ? 'selected' : '' }}>online</option>
                        <option value="onsite and online" {{ old('platform', $mentor->platform) == 'onsite and online' ? 'selected' : '' }}>onsite and online</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">working days</label>
                    <select name="working_days" class="w-full border border-gray-300 rounded p-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none bg-white" required>
                        <option value="everyday" {{ old('working_days', $mentor->working_days) == 'everyday' ? 'selected' : '' }}>everyday</option>
                        <option value="weekdays only" {{ old('working_days', $mentor->working_days) == 'weekdays only' ? 'selected' : '' }}>weekdays only</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">campus location</label>
                    <select name="location" class="w-full border border-gray-300 rounded p-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none bg-white" required>
                        <option value="Jakarta" {{ old('location', $mentor->location) == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                        <option value="Bandung" {{ old('location', $mentor->location) == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                        <option value="Surabaya" {{ old('location', $mentor->location) == 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                        <option value="Purwokerto" {{ old('location', $mentor->location) == 'Purwokerto' ? 'selected' : '' }}>Purwokerto</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">time schedule</label>
                        <input type="text" name="time_schedule" value="{{ old('time_schedule', $mentor->time_schedule) }}" class="w-full border border-gray-300 rounded p-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none" required>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">specialty</label>
                <textarea name="specialty" class="w-full border border-gray-300 rounded p-2 h-28 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none" required>{{ old('specialty', $mentor->specialty) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">profile upload</label>
                <div class="mt-1 flex items-center gap-4 border border-gray-300 rounded p-2 bg-gray-50">
                    @if($mentor->profile_image)
                        <div class="flex flex-col items-center gap-1 border-r pr-3 border-gray-300">
                            <span class="text-[9px] text-gray-400 font-bold uppercase">Current Image</span>
                            <img src="{{ asset('storage/' . $mentor->profile_image) }}" class="w-10 h-10 object-cover rounded border">
                        </div>
                    @endif
                    <input type="file" name="profile_image" class="w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-bold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer">
                </div>
            </div>

            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded text-sm tracking-wide uppercase transition shadow-md mt-4">
                save changes
            </button>
        </form>
    </div>
</div>
@endsection