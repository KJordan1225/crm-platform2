@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">Products</h1>
            <p class="text-muted">Manage products and services sold through the CRM.</p>
        </div>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            New Product
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
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Status</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->category }}</td>
                            <td>${{ number_format($product->unit_price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this product?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
