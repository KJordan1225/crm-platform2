@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Payments</h1>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Payment #</th>
                        <th>Invoice</th>
                        <th>Account</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Reference</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_number }}</td>
                            <td>{{ $payment->invoice?->invoice_number }}</td>
                            <td>{{ $payment->account?->name ?? 'N/A' }}</td>
                            <td>{{ $payment->payment_date?->format('m/d/Y') }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->method }}</td>
                            <td>{{ $payment->reference_number }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
