@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Apply for Scholarship</h4>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('application.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="scholarship_id" class="form-label">Select Scholarship</label>
                            <select name="scholarship_id" id="scholarship_id" class="form-select @error('scholarship_id') is-invalid @enderror" required>
                                <option value="">-- Choose Scholarship --</option>
                                @foreach($scholarships as $scholarship)
                                    <option value="{{ $scholarship->id }}">
                                        {{ $scholarship->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('scholarship_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit Application
                            </button>
                            <a href="{{ route('application.history') }}" class="btn btn-secondary">
                                View My Applications
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection