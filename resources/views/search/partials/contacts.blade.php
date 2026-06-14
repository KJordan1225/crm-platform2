<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <strong>Contacts</strong>
    </div>

    <div class="card-body">
        @forelse($contacts as $contact)
            <div class="border-bottom py-2">
                <a href="{{ route('contacts.show', $contact) }}" class="fw-bold">
                    {{ $contact->full_name }}
                </a>
                <div class="text-muted small">
                    {{ $contact->email }} — {{ $contact->phone }}
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">No contacts found.</p>
        @endforelse
    </div>
</div>
