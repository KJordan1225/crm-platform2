@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Accounts</h1>
        <a href="{{ route('accounts.create') }}" class="btn btn-primary">New Account</a>
        <a href="{{ route('exports.accounts') }}" class="btn btn-outline-success">
            Export CSV
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <x-crm.search-form
        :action="route('accounts.index')"
        placeholder="Search accounts by name, industry, email, or phone..."
    >
        <x-crm.select-filter
            name="industry"
            label="Industry"
            default="All Industries"
            :options="$industries"
            class="col-md-4"
        />
    </x-crm.search-form>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Industry</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                        <tr>
                            <td>{{ $account->name }}</td>
                            <td>{{ $account->industry }}</td>
                            <td>{{ $account->email }}</td>
                            <td>{{ $account->phone }}</td>
                            <td>
                                <a href="{{ route('accounts.show', $account) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('accounts.edit', $account) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this account?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $accounts->links() }}
        </div>
    </div>
</div>
@endsection
