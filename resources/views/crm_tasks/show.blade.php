@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h1 class="fw-bold">{{ $crmTask->title }}</h1>
        <a href="{{ route('crm-tasks.edit', $crmTask) }}" class="btn btn-warning">Edit Task</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <p><strong>Status:</strong> {{ $crmTask->status }}</p>
            <p><strong>Priority:</strong> {{ $crmTask->priority }}</p>
            <p><strong>Due Date:</strong> {{ $crmTask->due_date?->format('m/d/Y') }}</p>
            <p><strong>Completed At:</strong> {{ $crmTask->completed_at?->format('m/d/Y h:i A') }}</p>

            <p><strong>Description:</strong></p>
            <p>{{ $crmTask->description }}</p>
        </div>
    </div>
</div>
@endsection
