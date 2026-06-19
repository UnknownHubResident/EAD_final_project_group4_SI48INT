@extends('layouts.admin')

@section('content')
<div class="bg-gray-100 min-h-screen p-6">
    <div class="bg-red-900 text-white p-4 rounded-t-lg flex justify-between items-center">
        <h1 class="text-xl font-bold tracking-wide">admin panel</h1>
        <span class="font-semibold text-sm">test user1 ∨</span>
    </div>

    <div class="bg-white p-6 rounded-b-lg shadow border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">mentor/counselor management</h2>
            <a href="{{ route('admin.mentors.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold px-4 py-2 rounded text-xs tracking-wide uppercase transition shadow-sm">
                + add new mentors
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded-r text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-300 text-gray-700 text-xs font-bold uppercase tracking-wider">
                        <th class="p-3">mentor</th>
                        <th class="p-3">platform</th>
                        <th class="p-3">location</th>
                        <th class="p-3">specialty</th>
                        <th class="p-3 text-center">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mentors as $mentor)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 text-sm text-gray-800">
                        <td class="p-3 font-semibold flex items-center gap-3">
                            @if($mentor->profile_image)
                                <img src="{{ asset('storage/' . $mentor->profile_image) }}" class="w-8 h-8 rounded-full object-cover border border-gray-300">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500 font-bold">👤</div>
                            @endif
                            <span>{{ $mentor->name }}</span>
                        </td>
                        <td class="p-3">
                            <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded font-medium lowercase">{{ $mentor->platform }}</span>
                        </td>
                        <td class="p-3 font-medium text-gray-600">{{ $mentor->location }}</td>
                        <td class="p-3 text-xs max-w-xs truncate text-gray-600" title="{{ $mentor->specialty }}">
                            {{ $mentor->specialty }}
                        </td>
                        <td class="p-3">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('admin.mentors.edit', $mentor->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 text-xs font-bold px-3 py-1 rounded transition shadow-sm">edit</a>
                                <form action="{{ route('admin.mentors.destroy', $mentor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to completely remove this mentor?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3 py-1 rounded transition shadow-sm">delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500 text-sm">No active mentors found in database records. Click "+ add new mentors" to populate rows.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection