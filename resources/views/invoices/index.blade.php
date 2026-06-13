@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Invoices</h1>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Account</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->account?->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-secondary">{{ $invoice->status }}</span></td>
                            <td>${{ number_format($invoice->grand_total, 2) }}</td>
                            <td>${{ number_format($invoice->amount_paid, 2) }}</td>
                            <td>${{ number_format($invoice->balance_due, 2) }}</td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No invoices found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection
