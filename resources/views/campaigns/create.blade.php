@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Create Campaign</h1>

    <form action="{{ route('campaigns.store') }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf

        @include('campaigns.form')

        <button class="btn btn-primary">Save Campaign</button>
    </form>
</div>
@endsection
