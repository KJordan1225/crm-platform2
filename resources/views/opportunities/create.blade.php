@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Create Opportunity</h1>

    <form action="{{ route('opportunities.store') }}" method="POST" class="card card-body shadow-sm">
        @csrf

        @include('opportunities.form')

        <button class="btn btn-primary">Save Opportunity</button>
    </form>
</div>
@endsection
