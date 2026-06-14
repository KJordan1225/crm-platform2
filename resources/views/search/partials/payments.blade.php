<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <strong>Payments</strong>
    </div>

    <div class="card-body">
        @forelse($payments as $payment)
            <div class="border-bottom py-2">
                <span class="fw-bold">
                    {{ $payment->payment_number }}
                </span>
                <div class="text-muted small">
                    {{ $payment->method }} — ${{ number_format($payment->amount, 2) }}
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">No payments found.</p>
        @endforelse
    </div>
</div>
