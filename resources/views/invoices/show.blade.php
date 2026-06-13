@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">{{ $invoice->invoice_number }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card"><div class="card-body">
                <div class="stat-label">Total</div>
                <div class="stat-value">${{ number_format($invoice->grand_total, 2) }}</div>
            </div></div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card"><div class="card-body">
                <div class="stat-label">Paid</div>
                <div class="stat-value">${{ number_format($invoice->amount_paid, 2) }}</div>
            </div></div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card"><div class="card-body">
                <div class="stat-label">Balance</div>
                <div class="stat-value">${{ number_format($invoice->balance_due, 2) }}</div>
            </div></div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card"><div class="card-body">
                <div class="stat-label">Status</div>
                <div class="stat-value">{{ $invoice->status }}</div>
            </div></div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Invoice Details</strong></div>
                <div class="card-body">
                    <p><strong>Account:</strong> {{ $invoice->account?->name ?? 'N/A' }}</p>
                    <p><strong>Contact:</strong> {{ $invoice->contact?->full_name ?? 'N/A' }}</p>
                    <p><strong>Sales Order:</strong> {{ $invoice->salesOrder?->order_number ?? 'N/A' }}</p>
                    <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date?->format('m/d/Y') ?? 'N/A' }}</p>
                    <p><strong>Due Date:</strong> {{ $invoice->due_date?->format('m/d/Y') ?? 'N/A' }}</p>
                    <p><strong>Terms:</strong> {{ $invoice->terms }}</p>
                    <p><strong>Notes:</strong> {{ $invoice->notes }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Record Payment</strong></div>
                <div class="card-body">
                    <form action="{{ route('invoices.payments.store', $invoice) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Payment Date</label>
                            <input type="date" name="payment_date" class="form-control" value="{{ now()->toDateString() }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ $invoice->balance_due }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Method</label>
                            <select name="method" class="form-select">
                                <option value="Cash">Cash</option>
                                <option value="Check">Check</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="ACH">ACH</option>
                                <option value="Wire Transfer">Wire Transfer</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reference #</label>
                            <input type="text" name="reference_number" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" rows="3" class="form-control"></textarea>
                        </div>

                        <button class="btn btn-success w-100">Save Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white"><strong>Invoice Line Items</strong></div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Discount %</th>
                        <th>Tax %</th>
                        <th>Line Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoice->lineItems as $line)
                        <tr>
                            <td>{{ $line->product_name }}</td>
                            <td>{{ $line->sku }}</td>
                            <td>{{ $line->quantity }}</td>
                            <td>${{ number_format($line->unit_price, 2) }}</td>
                            <td>{{ number_format($line->discount_percent, 2) }}%</td>
                            <td>{{ number_format($line->tax_percent, 2) }}%</td>
                            <td>${{ number_format($line->line_total, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No line items.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white"><strong>Payments</strong></div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Payment #</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoice->payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_number }}</td>
                            <td>{{ $payment->payment_date?->format('m/d/Y') }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->method }}</td>
                            <td>{{ $payment->reference_number }}</td>
                            <td>
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this payment?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No payments recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
