@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">{{ $product->name }}</h1>
            <p class="text-muted mb-0">SKU: {{ $product->sku ?? 'N/A' }}</p>
        </div>

        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
            Edit Product
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <p><strong>Category:</strong> {{ $product->category }}</p>
            <p><strong>Unit Price:</strong> ${{ number_format($product->unit_price, 2) }}</p>
            <p><strong>Status:</strong> {{ $product->is_active ? 'Active' : 'Inactive' }}</p>
            <p><strong>Description:</strong></p>
            <p>{{ $product->description }}</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <strong>Price Book Entries</strong>
        </div>

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Price Book</th>
                        <th>List Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($product->priceBookEntries as $entry)
                        <tr>
                            <td>{{ $entry->priceBook?->name }}</td>
                            <td>${{ number_format($entry->list_price, 2) }}</td>
                            <td>{{ $entry->is_active ? 'Active' : 'Inactive' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">This product is not in any price books yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
