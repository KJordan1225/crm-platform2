@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Create Contact</h1>

    <form action="{{ route('contacts.store') }}" method="POST" class="card card-body shadow-sm">
        @csrf

        @include('contacts.form')

        <button class="btn btn-primary">Save Contact</button>
    </form>
</div>
@endsection
