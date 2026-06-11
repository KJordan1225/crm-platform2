@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Create Account</h1>

    <form action="{{ route('accounts.store') }}" method="POST" class="card card-body shadow-sm">
        @csrf

        @include('accounts.form')

        <button class="btn btn-primary">Save Account</button>
    </form>
</div>
@endsection
