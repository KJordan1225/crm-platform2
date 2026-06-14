<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <strong>Quotes</strong>
    </div>

    <div class="card-body">
        @forelse($quotes as $quote)
            <div class="border-bottom py-2">
                <a href="{{ route('quotes.show', $quote) }}" class="fw-bold">
                    {{ $quote->quote_number }} — {{ $quote->name }}
                </a>
                <div class="text-muted small">
                    {{ $quote->status }} — ${{ number_format($quote->grand_total, 2) }}
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">No quotes found.</p>
        @endforelse
    </div>
</div>
