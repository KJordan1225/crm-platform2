@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Edit Email Template</h1>

    <form action="{{ route('email-templates.update', $emailTemplate) }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf
        @method('PUT')

        @include('email_templates.form')

        <button class="btn btn-primary">Update Template</button>
    </form>
</div>
@endsection
