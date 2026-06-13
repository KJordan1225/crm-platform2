@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Create Quote</h1>

    <form action="{{ route('quotes.store') }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf

        @include('quotes.form')

        <button class="btn btn-primary">Save Quote</button>
    </form>
</div>
@endsection
