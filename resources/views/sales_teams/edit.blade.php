@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Edit Sales Team</h1>

    <form action="{{ route('sales-teams.update', $salesTeam) }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf
        @method('PUT')

        @include('sales_teams.form')

        <button class="btn btn-primary">Update Sales Team</button>
    </form>
</div>
@endsection
