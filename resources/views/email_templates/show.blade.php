@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">{{ $emailTemplate->name }}</h1>
            <p class="text-muted mb-0">{{ $emailTemplate->category }}</p>
        </div>

        <a href="{{ route('email-templates.edit', $emailTemplate) }}" class="btn btn-warning">
            Edit Template
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <p><strong>Subject:</strong> {{ $emailTemplate->subject }}</p>
            <p><strong>Status:</strong> {{ $emailTemplate->is_active ? 'Active' : 'Inactive' }}</p>

            <hr>

            <h5>Body</h5>
            <div class="border rounded p-3 bg-light">
                {!! nl2br(e($emailTemplate->body)) !!}
            </div>
        </div>
    </div>
</div>
@endsection
