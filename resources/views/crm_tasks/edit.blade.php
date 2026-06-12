@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Edit Task</h1>

    <form action="{{ route('crm-tasks.update', $crmTask) }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf
        @method('PUT')

        @include('crm_tasks.form')

        <button class="btn btn-primary">Update Task</button>
    </form>
</div>
@endsection
