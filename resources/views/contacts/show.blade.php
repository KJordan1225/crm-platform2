@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h1>{{ $contact->full_name }}</h1>
        <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning">Edit Contact</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Account:</strong> {{ $contact->account?->name ?? 'None' }}</p>
            <p><strong>Title:</strong> {{ $contact->title }}</p>
            <p><strong>Email:</strong> {{ $contact->email }}</p>
            <p><strong>Phone:</strong> {{ $contact->phone }}</p>
            <p><strong>Mobile:</strong> {{ $contact->mobile }}</p>
            <p><strong>Department:</strong> {{ $contact->department }}</p>
            <p><strong>Notes:</strong></p>
            <p>{{ $contact->notes }}</p>
        </div>
    </div>
</div>
@include('crm_shared.related_panel', ['model' => $contact])
@endsection
