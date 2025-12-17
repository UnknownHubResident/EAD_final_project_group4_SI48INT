@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>My Applications</h2>

    @if($applications->isEmpty())
        <p>No applications yet. <a href="{{ route('application.create') }}">Apply now</a></p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Scholarship</th>
                    <th>Status</th>
                    <th>Documents</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                    <tr>
                        <td>{{ $app->scholarship->name ?? 'N/A' }}</td>
                        <td>
                            @if($app->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($app->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $app->documents->count() }} files</td>
                        <td>{{ $app->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection