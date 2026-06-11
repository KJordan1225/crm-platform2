@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Edit Account</h1>

    <form action="{{ route('accounts.update', $account) }}" method="POST" class="card card-body shadow-sm">
        @csrf
        @method('PUT')

        @include('accounts.form')

        <button class="btn btn-primary">Update Account</button>
    </form>
</div>
@endsection
