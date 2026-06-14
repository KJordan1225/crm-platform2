<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <strong>Opportunities</strong>
    </div>

    <div class="card-body">
        @forelse($opportunities as $opportunity)
            <div class="border-bottom py-2">
                <a href="{{ route('opportunities.show', $opportunity) }}" class="fw-bold">
                    {{ $opportunity->name }}
                </a>
                <div class="text-muted small">
                    {{ $opportunity->stage }} — ${{ number_format($opportunity->amount, 2) }}
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">No opportunities found.</p>
        @endforelse
    </div>
</div>
