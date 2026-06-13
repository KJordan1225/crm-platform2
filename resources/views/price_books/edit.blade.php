@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Edit Price Book</h1>

    <form action="{{ route('price-books.update', $priceBook) }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf
        @method('PUT')

        @include('price_books.form')

        <button class="btn btn-primary">Update Price Book</button>
    </form>
</div>
@endsection
