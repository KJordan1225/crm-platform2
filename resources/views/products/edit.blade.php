@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Edit Product</h1>

    <form action="{{ route('products.update', $product) }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf
        @method('PUT')

        @include('products.form')

        <button class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection
