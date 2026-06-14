<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <strong>Leads</strong>
    </div>

    <div class="card-body">
        @forelse($leads as $lead)
            <div class="border-bottom py-2">
                <a href="{{ route('leads.show', $lead) }}" class="fw-bold">
                    {{ $lead->full_name }}
                </a>
                <div class="text-muted small">
                    {{ $lead->company }} — {{ $lead->status }}
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">No leads found.</p>
        @endforelse
    </div>
</div>
