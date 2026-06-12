@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Edit Contact</h1>

    <form action="{{ route('contacts.update', $contact) }}" method="POST" class="card card-body shadow-sm">
        @csrf
        @method('PUT')

        @include('contacts.form')

        <button class="btn btn-primary">Update Contact</button>
    </form>
</div>
@endsection
