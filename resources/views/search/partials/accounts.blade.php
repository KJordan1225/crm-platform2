<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <strong>Accounts</strong>
    </div>

    <div class="card-body">
        @forelse($accounts as $account)
            <div class="border-bottom py-2">
                <a href="{{ route('accounts.show', $account) }}" class="fw-bold">
                    {{ $account->name }}
                </a>
                <div class="text-muted small">
                    {{ $account->industry }} — {{ $account->email }}
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">No accounts found.</p>
        @endforelse
    </div>
</div>
