@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Global Search</h1>

    <form action="{{ route('search.index') }}" method="GET" class="card card-body shadow-sm border-0 mb-4">
        <div class="row g-3">
            <div class="col-md-10">
                <input type="text"
                       name="search"
                       class="form-control form-control-lg"
                       value="{{ $search }}"
                       placeholder="Search accounts, contacts, leads, opportunities, products, quotes, invoices, payments...">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary btn-lg w-100">
                    Search
                </button>
            </div>
        </div>
    </form>

    @if(!$search)
        <div class="alert alert-info">
            Enter a keyword to search the CRM.
        </div>
    @else
        <p class="text-muted">
            Showing results for: <strong>{{ $search }}</strong>
        </p>

        @include('search.partials.accounts')
        @include('search.partials.contacts')
        @include('search.partials.leads')
        @include('search.partials.opportunities')
        @include('search.partials.products')
        @include('search.partials.quotes')
        @include('search.partials.invoices')
        @include('search.partials.payments')
    @endif
</div>
@endsection
