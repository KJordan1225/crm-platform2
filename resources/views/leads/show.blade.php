@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h1>{{ $lead->full_name }}</h1>
        <a href="{{ route('leads.edit', $lead) }}" class="btn btn-warning">Edit Lead</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Company:</strong> {{ $lead->company }}</p>
            <p><strong>Email:</strong> {{ $lead->email }}</p>
            <p><strong>Phone:</strong> {{ $lead->phone }}</p>
            <p><strong>Status:</strong> {{ $lead->status }}</p>
            <p><strong>Source:</strong> {{ $lead->source }}</p>
            <p><strong>Industry:</strong> {{ $lead->industry }}</p>
            <p><strong>Estimated Value:</strong> ${{ number_format($lead->estimated_value, 2) }}</p>
            <p><strong>Notes:</strong></p>
            <p>{{ $lead->notes }}</p>
        </div>
    </div>
</div>
@endsection
