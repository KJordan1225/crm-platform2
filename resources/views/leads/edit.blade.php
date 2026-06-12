@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Edit Lead</h1>

    <form action="{{ route('leads.update', $lead) }}" method="POST" class="card card-body shadow-sm">
        @csrf
        @method('PUT')

        @include('leads.form')

        <button class="btn btn-primary">Update Lead</button>
    </form>
</div>
@endsection
