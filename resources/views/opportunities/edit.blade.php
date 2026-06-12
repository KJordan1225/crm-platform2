@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Edit Opportunity</h1>

    <form action="{{ route('opportunities.update', $opportunity) }}" method="POST" class="card card-body shadow-sm">
        @csrf
        @method('PUT')

        @include('opportunities.form')

        <button class="btn btn-primary">Update Opportunity</button>
    </form>
</div>
@endsection
