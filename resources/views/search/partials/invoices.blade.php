<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <strong>Invoices</strong>
    </div>

    <div class="card-body">
        @forelse($invoices as $invoice)
            <div class="border-bottom py-2">
                <a href="{{ route('invoices.show', $invoice) }}" class="fw-bold">
                    {{ $invoice->invoice_number }}
                </a>
                <div class="text-muted small">
                    {{ $invoice->status }} — Balance: ${{ number_format($invoice->balance_due, 2) }}
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">No invoices found.</p>
        @endforelse
    </div>
</div>
