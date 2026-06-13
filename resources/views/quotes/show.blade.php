@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">{{ $quote->name }}</h1>
            <p class="text-muted mb-0">Quote Number: {{ $quote->quote_number }}</p>
        </div>

        <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-warning">
            Edit Quote
        </a>
    </div>

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

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Subtotal</div>
                    <div class="stat-value">${{ number_format($quote->subtotal, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Discount</div>
                    <div class="stat-value">${{ number_format($quote->discount_total, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Tax</div>
                    <div class="stat-value">${{ number_format($quote->tax_total, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Grand Total</div>
                    <div class="stat-value">${{ number_format($quote->grand_total, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Quote Details</strong>
                </div>

                <div class="card-body">
                    <p><strong>Status:</strong> {{ $quote->status }}</p>
                    <p><strong>Opportunity:</strong> {{ $quote->opportunity?->name ?? 'N/A' }}</p>
                    <p><strong>Account:</strong> {{ $quote->account?->name ?? 'N/A' }}</p>
                    <p><strong>Contact:</strong> {{ $quote->contact?->full_name ?? 'N/A' }}</p>
                    <p><strong>Price Book:</strong> {{ $quote->priceBook?->name ?? 'N/A' }}</p>
                    <p><strong>Expiration Date:</strong> {{ $quote->expiration_date?->format('m/d/Y') ?? 'N/A' }}</p>

                    <p><strong>Terms:</strong></p>
                    <p>{{ $quote->terms }}</p>

                    <p><strong>Notes:</strong></p>
                    <p>{{ $quote->notes }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Add Line Item</strong>
                </div>

                <div class="card-body">
                    <form action="{{ route('quotes.line-items.store', $quote) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Product</label>
                            <select name="product_id" class="form-select">
                                <option value="">Custom Item</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }} — ${{ number_format($product->unit_price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Unit Price</label>
                            <input type="number" step="0.01" name="unit_price" class="form-control" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Discount %</label>
                            <input type="number" step="0.01" name="discount_percent" class="form-control" value="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tax %</label>
                            <input type="number" step="0.01" name="tax_percent" class="form-control" value="0">
                        </div>

                        <button class="btn btn-primary w-100">
                            Add Item
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <strong>Quote Line Items</strong>
        </div>

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
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($quote->lineItems as $line)
                        <tr>
                            <td>{{ $line->product_name }}</td>
                            <td>{{ $line->sku }}</td>
                            <td>{{ $line->quantity }}</td>
                            <td>${{ number_format($line->unit_price, 2) }}</td>
                            <td>{{ number_format($line->discount_percent, 2) }}%</td>
                            <td>{{ number_format($line->tax_percent, 2) }}%</td>
                            <td>${{ number_format($line->line_total, 2) }}</td>
                            <td>
                                <form action="{{ route('quote-line-items.destroy', $line) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Remove this line item?')" class="btn btn-sm btn-danger">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No line items added yet.</td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="6" class="text-end">Subtotal</th>
                        <th>${{ number_format($quote->subtotal, 2) }}</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Discount</th>
                        <th>${{ number_format($quote->discount_total, 2) }}</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Tax</th>
                        <th>${{ number_format($quote->tax_total, 2) }}</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end">Grand Total</th>
                        <th>${{ number_format($quote->grand_total, 2) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
