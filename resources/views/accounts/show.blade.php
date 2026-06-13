@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>{{ $account->name }}</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>Industry:</strong> {{ $account->industry }}</p>
            <p><strong>Email:</strong> {{ $account->email }}</p>
            <p><strong>Phone:</strong> {{ $account->phone }}</p>
            <p><strong>Website:</strong> {{ $account->website }}</p>
            <p><strong>Description:</strong> {{ $account->description }}</p>
        </div>
    </div>

    <h3>Contacts</h3>
    <ul class="list-group mb-4">
        @forelse($account->contacts as $contact)
            <li class="list-group-item">
                {{ $contact->full_name }} - {{ $contact->email }}
            </li>
        @empty
            <li class="list-group-item">No contacts.</li>
        @endforelse
    </ul>

    <h3>Opportunities</h3>
    <ul class="list-group">
        @forelse($account->opportunities as $opportunity)
            <li class="list-group-item">
                {{ $opportunity->name }} - ${{ number_format($opportunity->amount, 2) }}
            </li>
        @empty
            <li class="list-group-item">No opportunities.</li>
        @endforelse
    </ul>
</div>
@include('crm_shared.related_panel', ['model' => $account])
@endsection
