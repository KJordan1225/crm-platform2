@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">Quotes</h1>
            <p class="text-muted">Create customer quotes from opportunities, products, and price books.</p>
        </div>

        <a href="{{ route('quotes.create') }}" class="btn btn-primary">
            New Quote
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Quote #</th>
                        <th>Name</th>
                        <th>Account</th>
                        <th>Opportunity</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($quotes as $quote)
                        <tr>
                            <td>{{ $quote->quote_number }}</td>
                            <td>{{ $quote->name }}</td>
                            <td>{{ $quote->account?->name ?? 'N/A' }}</td>
                            <td>{{ $quote->opportunity?->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $quote->status }}</span>
                            </td>
                            <td>${{ number_format($quote->grand_total, 2) }}</td>
                            <td>
                                <a href="{{ route('quotes.show', $quote) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this quote?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No quotes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $quotes->links() }}
        </div>
    </div>
</div>
@endsection
