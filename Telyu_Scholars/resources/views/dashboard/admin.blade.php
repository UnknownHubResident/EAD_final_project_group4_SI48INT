@extends('layouts.admin')

@section('content')
<div class="bg-gray-100 min-h-screen p-6">
    {{-- Header block stylized identically to match your wireframe guidelines --}}
    <div class="bg-red-900 text-white p-4 rounded-t-lg flex justify-between items-center">
        <h1 class="text-xl font-bold tracking-wide">admin panel</h1>
        <div>
            <span class="font-semibold select-none opacity-90">
                {{ Auth::user()->name ?? 'test user1' }} ∨
            </span>
        </div>
    </div>

    <div class="bg-white p-8 shadow-md rounded-b-lg border border-gray-200">
        <h2 class="text-3xl font-extrabold text-gray-800">Admin Control Panel</h2>
        <p class="text-sm text-gray-600 mt-1">Welcome, <span class="font-bold">AdminOne!</span> Access granted via <span class="bg-red-600 text-white px-2 py-0.5 rounded text-xs">admin</span> role</p>

        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-3 my-6 rounded-r text-sm">
            <p><span class="font-bold">Security check:</span> this page confirms the security check passed successfully</p>
        </div>

        <h3 class="text-xl font-bold text-gray-700 mb-4">Admin Tasks</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="#" class="flex items-center p-4 border border-gray-300 rounded-md hover:bg-gray-50 transition shadow-sm">
                <div class="bg-orange-100 p-3 rounded mr-4 text-orange-600">📄</div>
                <span class="font-bold text-gray-800">Pending Provider applications</span>
            </a>

            <a href="{{ route('admin.scholarships.index') }}" class="flex items-center p-4 border border-gray-300 rounded-md hover:bg-gray-50 transition shadow-sm">
                <div class="bg-red-100 p-3 rounded mr-4 text-red-600">📑</div>
                <span class="font-bold text-gray-800">manage all shcolarhsip</span>
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 border border-gray-300 rounded-md hover:bg-gray-50 transition shadow-sm">
                <div class="bg-blue-100 p-3 rounded mr-4 text-blue-600">👥</div>
                <span class="font-bold text-gray-800">manage all user</span>
            </a>

            <div class="flex items-center p-4 border border-gray-200 bg-gray-50 rounded-md opacity-60">
                <div class="bg-gray-200 p-3 rounded mr-4 text-gray-500">⚙️</div>
                <span class="font-bold text-gray-400">System configuration</span>
            </div>

            <a href="{{ route('admin.bookings.index') }}" class="flex items-center p-4 border border-gray-300 rounded-md hover:bg-gray-50 transition shadow-sm">
                <div class="bg-yellow-100 p-3 rounded mr-4 text-yellow-600">📋</div>
                <span class="font-bold text-gray-800">pending consultation booking</span>
            </a>

            <a href="{{ route('admin.mentors.index') }}" class="flex items-center p-4 border border-gray-300 rounded-md hover:bg-gray-50 transition shadow-sm">
                <div class="bg-green-100 p-3 rounded mr-4 text-green-600">🟢</div>
                <span class="font-bold text-gray-800">manage all mentors</span>
            </a>
        </div>

        <div class="mt-8 flex justify-end">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-bold px-6 py-2 rounded flex items-center transition">
                    <span class="mr-2">🚪</span> Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection