@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Create Price Book</h1>

    <form action="{{ route('price-books.store') }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf

        @include('price_books.form')

        <button class="btn btn-primary">Save Price Book</button>
    </form>
</div>
@endsection
