@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">{{ $salesOrder->order_number }}</h1>
            <p class="text-muted mb-0">{{ $salesOrder->status }}</p>
        </div>

        <form action="{{ route('sales-orders.convert-to-invoice', $salesOrder) }}" method="POST">
            @csrf
            <button onclick="return confirm('Convert this sales order to an invoice?')" class="btn btn-success">
                Convert to Invoice
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <p><strong>Account:</strong> {{ $salesOrder->account?->name ?? 'N/A' }}</p>
            <p><strong>Contact:</strong> {{ $salesOrder->contact?->full_name ?? 'N/A' }}</p>
            <p><strong>Quote:</strong> {{ $salesOrder->quote?->quote_number ?? 'N/A' }}</p>
            <p><strong>Opportunity:</strong> {{ $salesOrder->opportunity?->name ?? 'N/A' }}</p>
            <p><strong>Order Date:</strong> {{ $salesOrder->order_date?->format('m/d/Y') ?? 'N/A' }}</p>
            <p><strong>Notes:</strong> {{ $salesOrder->notes }}</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white"><strong>Line Items</strong></div>

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
                    @forelse($salesOrder->lineItems as $line)
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
                <tfoot>
                    <tr>
                        <th colspan="6" class="text-end">Subtotal</th>
                        <th>${{ number_format($salesOrder->subtotal, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Discount</th>
                        <th>${{ number_format($salesOrder->discount_total, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Tax</th>
                        <th>${{ number_format($salesOrder->tax_total, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Grand Total</th>
                        <th>${{ number_format($salesOrder->grand_total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
