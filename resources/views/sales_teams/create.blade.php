@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Create Sales Team</h1>

    <form action="{{ route('sales-teams.store') }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf

        @include('sales_teams.form')

        <button class="btn btn-primary">Save Sales Team</button>
    </form>
</div>
@endsection
