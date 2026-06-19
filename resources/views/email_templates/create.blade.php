@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Create Email Template</h1>

    <form action="{{ route('email-templates.store') }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf

        @include('email_templates.form')

        <button class="btn btn-primary">Save Template</button>
    </form>
</div>
@endsection
