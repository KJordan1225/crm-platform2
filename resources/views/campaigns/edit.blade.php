@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Edit Campaign</h1>

    <form action="{{ route('campaigns.update', $campaign) }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf
        @method('PUT')

        @include('campaigns.form')

        <button class="btn btn-primary">Update Campaign</button>
    </form>
</div>
@endsection
