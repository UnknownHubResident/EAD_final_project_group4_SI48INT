@extends('layouts.student')

@section('content')
<div class="bg-gray-100 min-h-screen py-6" x-data="{ 
    openModal: false, 
    activeMentorId: '', 
    activeMentorName: '',
    activeMentorSpecialty: '',
    activeMentorPlatform: '',
    activeMentorLocation: '',
    activeMentorSchedule: '',
    activeMentorImage: ''
}">
    <div class="max-w-6xl mx-auto px-4">
        
        {{-- Header Breadcrumb Control --}}
        <div class="mb-4">
            <a href="{{ route('student.bookings.index') }}" class="text-xs text-gray-500 hover:text-gray-700 flex items-center gap-1">
                &lt; back to mentor management
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-1">Search mentor/counselor screens</h1>
        </div>

        @if($mentors->isEmpty())
            <div class="bg-white rounded-lg p-8 text-center shadow-sm border border-gray-200">
                <p class="text-gray-500">No mentors available at this time.</p>
            </div>
        @else
            {{-- Figma Grid Layout matching catalog cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($mentors as $mentor)
                    @php
                        // Fixed: Using profile_image to match your database migration schema exactly
                        $hasImage = isset($mentor->profile_image) && $mentor->profile_image;
                        $imageUrl = $hasImage ? asset('storage/' . $mentor->profile_image) : null;
                        
                        $specialty = isset($mentor->specialty) ? $mentor->specialty : 'Mental Wellness';
                        $platform = isset($mentor->platform) ? $mentor->platform : 'online';
                        $location = isset($mentor->location) ? $mentor->location : 'Bandung';
                        $schedule = isset($mentor->time_schedule) ? $mentor->time_schedule : '08:30 - 16:30';
                    @endphp

                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex flex-col justify-between items-center text-center">
                        <div class="w-full flex flex-col items-center">
                            {{-- Avatar Block --}}
                            @if($hasImage)
                                <img src="{{ $imageUrl }}" alt="Avatar" class="w-24 h-24 bg-gray-100 border border-gray-300 p-1 mb-3 object-cover">
                            @else
                                <div class="w-24 h-24 border border-gray-300 bg-gray-50 flex items-center justify-center mb-3 relative text-gray-400">
                                    <div class="absolute inset-0 border-t border-b transform rotate-45 scale-105 border-gray-200"></div>
                                    <div class="absolute inset-0 border-t border-b transform -rotate-45 scale-105 border-gray-200"></div>
                                    <span class="text-xs text-gray-400 relative z-10">Photo Placeholder</span>
                                </div>
                            @endif

                            <h3 class="text-red-700 font-bold text-base leading-tight">{{ $mentor->name }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Specialty: {{ $specialty }}</p>
                            <p class="text-xs text-gray-400 italic">Platform: {{ $platform }}</p>
                        </div>

                        <button 
                            type="button"
                            @click="
                                openModal = true; 
                                activeMentorId = '{{ $mentor->id }}'; 
                                activeMentorName = '{{ $mentor->name }}';
                                activeMentorSpecialty = '{{ $specialty }}';
                                activeMentorPlatform = '{{ $platform }}';
                                activeMentorLocation = '{{ $location }}';
                                activeMentorSchedule = '{{ $schedule }}';
                                activeMentorImage = '{{ $imageUrl }}';
                            "
                            class="mt-4 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold py-1.5 px-4 rounded shadow-sm transition"
                        >
                            Book Now
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- DETAIL + ACTION MODAL --}}
    <div 
        x-show="openModal" 
        class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4"
        x-cloak
    >
        <div class="bg-white rounded shadow-xl max-w-2xl w-full overflow-hidden border border-gray-300 animate-in fade-in duration-100">
            
            {{-- Section Bar Top Layout Style --}}
            <div class="bg-red-800 text-white px-4 py-2 flex justify-between items-center">
                <span class="text-xs font-mono tracking-wider font-semibold">STUDENT PANEL</span>
                <button @click="openModal = false" class="text-white text-lg font-bold hover:text-gray-200">&times;</button>
            </div>

            <div class="p-5">
                <button type="button" @click="openModal = false" class="text-xs text-gray-500 hover:underline mb-4 inline-block">
                    &lt; back to mentor management
                </button>

                <form action="{{ route('student.bookings.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    @csrf
                    <input type="hidden" name="mentor_id" :value="activeMentorId">

                    {{-- Left Card Column: Profile Specifications View --}}
                    <div class="md:col-span-5 flex flex-col items-center md:items-start text-center md:text-left border-b md:border-b-0 md:border-r border-gray-200 pb-4 md:pb-0 md:pr-4">
                        <template x-if="activeMentorImage">
                            <img :src="activeMentorImage" class="w-36 h-44 border border-gray-300 p-1 object-cover bg-gray-50 mb-3" alt="Mentor profile">
                        </template>
                        <template x-if="!activeMentorImage">
                            <div class="w-36 h-44 border border-gray-300 bg-gray-100 flex items-center justify-center relative text-gray-400 mb-3">
                                <div class="absolute inset-0 border-t border-b transform rotate-45 border-gray-200"></div>
                                <span class="text-xs relative p-2">No Profile Image</span>
                            </div>
                        </template>

                        <h2 class="text-xl font-bold text-red-600 mb-2" x-text="activeMentorName"></h2>
                        
                        <div class="text-xs space-y-1.5 text-gray-600 w-full">
                            <p><strong>working days:</strong> <span class="text-gray-900">everyday</span></p>
                            <p><strong>available time:</strong> <span class="text-gray-900" x-text="activeMentorSchedule"></span></p>
                            <p><strong>mentorship platform:</strong> <span class="text-gray-900" x-text="activeMentorPlatform"></span></p>
                            <p><strong>campus location:</strong> <span class="text-gray-900" x-text="activeMentorLocation"></span></p>
                            <p><strong>specialty:</strong> <span class="text-gray-900" x-text="activeMentorSpecialty"></span></p>
                        </div>
                    </div>

                    {{-- Right Card Column: Interactive Parameters Form Elements --}}
                    <div class="md:col-span-7 flex flex-col justify-between">
                        <div>
                            <div class="bg-red-500 text-white text-xs font-semibold px-3 py-1.5 rounded mb-4">
                                applying schedule text details
                            </div>

                            <div class="space-y-4 text-xs">
                                {{-- Target Session Date Pick --}}
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-1">Select Date</label>
                                    <input 
                                        type="date" 
                                        name="booking_date" 
                                        required 
                                        class="w-full bg-white border border-gray-300 rounded p-2 text-gray-900 outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500"
                                    >
                                </div>

                                {{-- Figma Specific Time-slot Selection List --}}
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-1">Select Time Session</label>
                                    <select 
                                        name="booking_slot" 
                                        required 
                                        class="w-full bg-white border border-gray-300 rounded p-2 text-gray-900 outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500"
                                    >
                                        <option value="" disabled selected>-- Choose an available slot --</option>
                                        <option value="06:30 - 08:30">06:30 - 08:30</option>
                                        <option value="08:30 - 10:30">08:30 - 10:30</option>
                                        <option value="10:30 - 12:30">10:30 - 12:30</option>
                                        <option value="12:30 - 14:30">12:30 - 14:30</option>
                                        <option value="14:30 - 16:30">14:30 - 16:30</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-700 font-semibold mb-1">Consultation Notes / Description</label>
                                    <textarea 
                                        name="notes" 
                                        rows="3" 
                                        placeholder="Type your notes or explicit consultation targets here..." 
                                        class="w-full bg-white border border-gray-300 rounded p-2 text-gray-900 outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 resize-none text-xs"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Form Row Actions Trigger --}}
                        <div class="mt-6 pt-2">
                            <button 
                                type="submit" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold text-xs py-2 rounded shadow-sm tracking-wide uppercase transition"
                            >
                                insert booking
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection