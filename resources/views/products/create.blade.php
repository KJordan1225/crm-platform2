@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Create Product</h1>

    <form action="{{ route('products.store') }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf

        @include('products.form')

        <button class="btn btn-primary">Save Product</button>
    </form>
</div>
@endsection
