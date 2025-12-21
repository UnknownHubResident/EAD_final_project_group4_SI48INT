@extends('layouts.student')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    
    {{-- Header Section --}}
    <div class="mb-8 border-b border-gray-100 pb-6 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                <span class="text-red-600">📚</span> Student Dashboard
            </h1>
            <p class="mt-2 text-lg text-gray-600">
                Welcome back, <span class="font-bold text-gray-900">{{ Auth::user()->name }}</span>!
            </p>
        </div>
        {{-- Status Badge --}}
        <div class="hidden md:block">
             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ Auth::user()->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                Status: {{ Auth::user()->is_approved ? 'Active' : 'Pending' }}
            </span>
        </div>
    </div>

    {{-- Info Box --}}
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-lg">
        <p class="text-sm text-blue-700">
            <strong>Info:</strong> Your student portal is active and ready to use.
        </p>
    </div>

    {{-- Menu Section --}}
    <h2 class="text-xl font-bold mb-4 text-gray-800">Student Menu</h2>
    
    <div class="space-y-3">
        {{-- Item 1: View Available Scholarships --}}
        <a href="{{ route('student.scholarships.index') }}" 
           class="group flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-200 cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-red-600">View Available Scholarships</h3>
                    <p class="text-sm text-gray-500">Browse and apply for funding opportunities</p>
                </div>
            </div>
            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>

        {{-- Item 2: View My Applications --}}
        <a href="{{ route('student.applications.index') }}" 
           class="group flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-200 cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-red-600">View My Applications</h3>
                    <p class="text-sm text-gray-500">Track your history and application status</p>
                </div>
            </div>
            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>

        {{-- Item 3: Update Profile  --}}
        <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-100 rounded-xl opacity-60 cursor-not-allowed">
            <div class="flex items-center gap-4">
                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-500">Update Profile</h3>
                    <p class="text-sm text-gray-400">Feature coming soon</p>
                </div>
            </div>
            <span class="text-xs font-medium bg-gray-200 text-gray-500 px-2 py-1 rounded">Soon</span>
        </div>
    </div>

    {{-- Footer Section --}}
    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="text-sm text-gray-500 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            Role: <span class="font-semibold text-gray-700 uppercase tracking-wide text-xs">{{ Auth::user()->role }}</span>
        </p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 font-medium rounded-lg transition duration-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </div>
</div>
@endsection