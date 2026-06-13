@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h1>{{ $opportunity->name }}</h1>
        <a href="{{ route('opportunities.edit', $opportunity) }}" class="btn btn-warning">Edit Opportunity</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Account:</strong> {{ $opportunity->account?->name ?? 'None' }}</p>
            <p><strong>Amount:</strong> ${{ number_format($opportunity->amount, 2) }}</p>
            <p><strong>Stage:</strong> {{ $opportunity->stage }}</p>
            <p><strong>Probability:</strong> {{ $opportunity->probability }}%</p>
            <p><strong>Close Date:</strong> {{ $opportunity->close_date }}</p>
            <p><strong>Source:</strong> {{ $opportunity->source }}</p>
            <p><strong>Description:</strong></p>
            <p>{{ $opportunity->description }}</p>
        </div>
    </div>
</div>
@include('crm_shared.related_panel', ['model' => $opportunity])
@endsection
