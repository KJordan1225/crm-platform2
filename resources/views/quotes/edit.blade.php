@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Edit Quote</h1>

    <form action="{{ route('quotes.update', $quote) }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf
        @method('PUT')

        @include('quotes.form')

        <button class="btn btn-primary">Update Quote</button>
    </form>
</div>
@endsection
