@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">{{ $priceBook->name }}</h1>
            <p class="text-muted mb-0">
                {{ $priceBook->is_standard ? 'Standard Price Book' : 'Custom Price Book' }}
            </p>
        </div>

        <a href="{{ route('price-books.edit', $priceBook) }}" class="btn btn-warning">
            Edit Price Book
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
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Price Book Details</strong>
                </div>

                <div class="card-body">
                    <p><strong>Status:</strong> {{ $priceBook->is_active ? 'Active' : 'Inactive' }}</p>
                    <p><strong>Description:</strong></p>
                    <p>{{ $priceBook->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Add Product Price</strong>
                </div>

                <div class="card-body">
                    <form action="{{ route('price-books.entries.store', $priceBook) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Product</label>
                            <select name="product_id" class="form-select" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }} — ${{ number_format($product->unit_price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">List Price</label>
                            <input type="number" step="0.01" name="list_price" class="form-control" required>
                        </div>

                        <div class="form-check mb-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                   id="entry_is_active" checked>
                            <label for="entry_is_active" class="form-check-label">
                                Active Entry
                            </label>
                        </div>

                        <button class="btn btn-primary w-100">
                            Save Entry
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <strong>Products in This Price Book</strong>
        </div>

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>List Price</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($priceBook->entries as $entry)
                        <tr>
                            <td>{{ $entry->product?->name }}</td>
                            <td>{{ $entry->product?->sku }}</td>
                            <td>${{ number_format($entry->list_price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $entry->is_active ? 'success' : 'secondary' }}">
                                    {{ $entry->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('price-book-entries.destroy', $entry) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Remove this entry?')" class="btn btn-sm btn-danger">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No products have been added to this price book yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
