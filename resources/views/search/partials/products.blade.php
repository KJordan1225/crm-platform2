<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <strong>Products</strong>
    </div>

    <div class="card-body">
        @forelse($products as $product)
            <div class="border-bottom py-2">
                <a href="{{ route('products.show', $product) }}" class="fw-bold">
                    {{ $product->name }}
                </a>
                <div class="text-muted small">
                    SKU: {{ $product->sku }} — ${{ number_format($product->unit_price, 2) }}
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">No products found.</p>
        @endforelse
    </div>
</div>
