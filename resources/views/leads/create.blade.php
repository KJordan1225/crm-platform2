@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Create Lead</h1>

    <form action="{{ route('leads.store') }}" method="POST" class="card card-body shadow-sm">
        @csrf

        @include('leads.form')

        <button class="btn btn-primary">Save Lead</button>
    </form>
</div>
@endsection
