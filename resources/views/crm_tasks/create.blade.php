@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Create Task</h1>

    <form action="{{ route('crm-tasks.store') }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf

        @include('crm_tasks.form')

        <button class="btn btn-primary">Save Task</button>
    </form>
</div>
@endsection
