@extends('layouts.student')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    {{-- Main Container: Modern UI Box --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 space-y-8">
        
        {{-- 1. Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 pb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                    <span class="text-red-600">📚</span> Student Dashboard
                </h1>
                <p class="mt-2 text-gray-600">
                    Welcome back, <span class="font-bold text-gray-900">{{ Auth::user()->name }}</span>!
                </p>
            </div>
            
            {{-- Status Badge --}}
            <div class="mt-4 md:mt-0">
                 <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium {{ Auth::user()->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    Status: {{ Auth::user()->is_approved ? 'Active' : 'Pending' }}
                </span>
            </div>
        </div>

        {{-- 2. System Info Box --}}
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
            <p class="text-sm text-blue-700">
                <strong>Student Access:</strong> You can browse available scholarships and track your application status in real-time.
            </p>
        </div>

        {{-- 3. Student Menu (Vertical List Layout) --}}
        <div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h3>
            
            {{-- Changed grid-cols-2 to grid-cols-1 for vertical alignment --}}
            <div class="grid grid-cols-1 gap-4 max-w-2xl">
                
                {{-- Action 1: Find Scholarships --}}
                <a href="{{ route('student.scholarships.index') }}" 
                   class="group p-5 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-200 flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 group-hover:text-red-600 transition-colors">Find Scholarships</h4>
                        <p class="text-sm text-gray-500">Browse and apply for available funds</p>
                    </div>
                </a>

                {{-- Action 2: Application View --}}
                <a href="{{ route('student.applications.index') }}" 
                   class="group p-5 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-200 flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 group-hover:text-red-600 transition-colors">Application View</h4>
                        <p class="text-sm text-gray-500">Track the status of your submissions</p>
                    </div>
                </a>

                {{-- Action 3: Profile Settings (Placeholder) --}}
                <div class="p-5 bg-gray-50 border border-gray-100 rounded-xl opacity-60 cursor-not-allowed flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-200 text-gray-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-500">Edit Profile</h4>
                        <p class="text-sm text-gray-400">Update coming soon</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- 4. Footer & Logout Section --}}
        <div class="pt-6 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            
            {{-- Role Info --}}
            <p class="text-sm text-gray-500">
                Role: <span class="font-mono bg-gray-100 text-gray-700 px-2 py-0.5 rounded uppercase font-bold">{{ Auth::user()->role }}</span>
            </p>

            {{-- Logout Button --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow font-medium transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection