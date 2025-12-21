@extends('layouts.provider')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    {{-- Main Container: The modern UI you circled in your screenshot --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 space-y-8">

        {{-- 1. Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 pb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                    <span class="text-red-600">💼</span> Scholar Provider Dashboard
                </h1>
                <p class="mt-2 text-gray-600">
                    Welcome, <span class="font-bold text-gray-900">{{ Auth::user()->name }}</span>!
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Your Provider account is currently <span class="font-bold {{ Auth::user()->is_approved ? 'text-green-600' : 'text-yellow-600' }}">active</span>.
                </p>
            </div>
            
            {{-- Status Badge --}}
            <div class="mt-4 md:mt-0">
                 <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium {{ Auth::user()->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    Status: {{ Auth::user()->is_approved ? 'Approved' : 'Pending Review' }}
                </span>
            </div>
        </div>

        {{-- 2. System Info Box --}}
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
            <p class="text-sm text-green-700">
                <strong>System Check:</strong> This page confirms successful Admin approval and correct final routing.
            </p>
        </div>

        {{-- 3. Provider Menu (Grid Layout) --}}
        <div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Provider Menu</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                {{-- Action 1: Create New Scholarship --}}
                <a href="{{ route('provider.scholarships.create') }}" 
                   class="group p-5 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-200 flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 group-hover:text-red-600 transition-colors">Create New Scholarship</h4>
                        <p class="text-sm text-gray-500">Launch a new funding program</p>
                    </div>
                </a>

                {{-- Action 2: Manage Existing Scholarships --}}
                <a href="{{ route('provider.scholarships.index') }}" 
                   class="group p-5 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-200 flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 group-hover:text-red-600 transition-colors">Manage Scholarships</h4>
                        <p class="text-sm text-gray-500">Edit or track your existing programs</p>
                    </div>
                </a>

                {{-- Action 3: Review Applications (NOW ACTIVE) --}}
                <a href="{{ route('provider.applications.index') }}" 
                   class="group p-5 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-200 flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 group-hover:text-red-600 transition-colors">Review Applications</h4>
                        <p class="text-sm text-gray-500">Evaluate student submissions</p>
                    </div>
                </a>

                {{-- Action 4: Payment History (Placeholder) --}}
                <div class="p-5 bg-gray-50 border border-gray-100 rounded-xl opacity-60 cursor-not-allowed flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-200 text-gray-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-500">Payment History</h4>
                        <p class="text-sm text-gray-400">Placeholder (Coming Soon)</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- 4. Footer & Logout Section --}}
        <div class="pt-6 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            
            {{-- Role Info --}}
            <p class="text-sm text-gray-500">
                Role: <span class="font-mono bg-gray-100 text-gray-700 px-2 py-0.5 rounded uppercase">{{ Auth::user()->role }}</span>
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