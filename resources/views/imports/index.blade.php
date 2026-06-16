@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">CSV Imports</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Fix the following errors:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Import Accounts</strong>
                </div>

                <div class="card-body">
                    <p class="text-muted small">
                        Required header: name. Optional: industry, website, phone, email, description.
                    </p>

                    <form action="{{ route('imports.accounts') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="file" name="csv_file" class="form-control mb-3" required>

                        <button class="btn btn-primary w-100">
                            Upload Accounts CSV
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Import Contacts</strong>
                </div>

                <div class="card-body">
                    <p class="text-muted small">
                        Required headers: first_name, last_name. Optional: account_email, email, title, phone, mobile, department, notes.
                    </p>

                    <form action="{{ route('imports.contacts') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="file" name="csv_file" class="form-control mb-3" required>

                        <button class="btn btn-primary w-100">
                            Upload Contacts CSV
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Import Leads</strong>
                </div>

                <div class="card-body">
                    <p class="text-muted small">
                        Required headers: first_name, last_name. Optional: company, email, phone, status, source, industry, estimated_value, notes.
                    </p>

                    <form action="{{ route('imports.leads') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="file" name="csv_file" class="form-control mb-3" required>

                        <button class="btn btn-primary w-100">
                            Upload Leads CSV
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
