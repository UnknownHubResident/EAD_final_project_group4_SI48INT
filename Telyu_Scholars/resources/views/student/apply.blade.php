@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-red-600 py-6 text-center">
            <h2 class="text-2xl font-bold text-white uppercase tracking-wider">Apply for Scholarship</h2>
        </div>

        <div class="p-6">
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                    <strong class="block font-semibold mb-1">Error!</strong>
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('application.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="scholarship_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Select Scholarship
                    </label>
                    <select name="scholarship_id" id="scholarship_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-colors">
                        <option value="">-- Choose Scholarship --</option>
                        @foreach($scholarships as $scholarship)
                            <option value="{{ $scholarship->id }}">
                                {{ $scholarship->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col sm:flex-row sm:gap-4 items-center justify-between">
                    <button type="submit" 
                        class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 duration-200">
                        Submit Application
                    </button>
                    <a href="{{ route('application.history') }}"
                        class="w-full sm:w-auto mt-3 sm:mt-0 inline-block text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-6 rounded-lg shadow-sm transition">
                        View My Applications
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
