@extends('layouts.admin')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    
    {{-- 1. Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                <span class="text-red-600">🚨</span> Admin Control Panel
            </h1>
            <p class="mt-2 text-gray-600">
                Welcome, <span class="font-bold text-gray-900">{{ Auth::user()->name }}</span>!
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Access granted via <span class="font-mono bg-red-50 text-red-600 px-2 py-0.5 rounded font-bold">{{ Auth::user()->role }}</span> role.
            </p>
        </div>
        
        {{-- Status Badge --}}
        <div class="mt-4 md:mt-0">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium {{ Auth::user()->is_approved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                Status: {{ Auth::user()->is_approved ? 'Approved' : 'Pending' }}
            </span>
        </div>
    </div>

    {{-- 2. System Note (Sesuai teks asli: confirms security check passed) --}}
    <div class="mb-8 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
        <p class="text-sm text-blue-700">
            <strong>Security Check:</strong> This page confirms the security check passed successfully.
        </p>
    </div>

    {{-- 3. Admin Tasks (Grid Menu) --}}
    <h3 class="text-xl font-bold text-gray-900 mb-4">Admin Tasks</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        {{-- Task 1: Pending Providers --}}
        <a href="{{ route('admin.pending') }}" 
           class="group p-5 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors">
                {{-- Icon: Document Exclamation --}}
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 group-hover:text-red-600 transition-colors">Pending Provider Applications</h4>
                <p class="text-sm text-gray-500">View applications requiring approval</p>
            </div>
        </a>

        {{-- Task 2: Manage Scholarships --}}
        <a href="{{ route('admin.scholarships.index') }}" 
           class="group p-5 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                {{-- Icon: Academic Cap --}}
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 group-hover:text-red-600 transition-colors">Manage All Scholarships</h4>
                <p class="text-sm text-gray-500">Oversee all scholarship listings</p>
            </div>
        </a>

        {{-- Task 3: Manage Users --}}
        <a href="{{ route('admin.users.index') }}" 
           class="group p-5 bg-white border border-gray-200 rounded-xl hover:border-red-500 hover:shadow-md transition-all duration-200 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                {{-- Icon: Users --}}
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 group-hover:text-red-600 transition-colors">Manage All Users</h4>
                <p class="text-sm text-gray-500">Control user accounts and roles</p>
            </div>
        </a>

        {{-- Task 4: Configuration (Placeholder) --}}
        <div class="p-5 bg-gray-50 border border-gray-200 rounded-xl opacity-60 cursor-not-allowed flex items-center gap-4">
            <div class="w-12 h-12 bg-gray-200 text-gray-500 rounded-lg flex items-center justify-center">
                {{-- Icon: Cog --}}
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-500">System Configuration</h4>
                <p class="text-sm text-gray-400">Placeholder (Coming Soon)</p>
            </div>
        </div>

    </div>

    {{-- 4. Logout Section --}}
    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow font-medium transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </div>

</div>
@endsection