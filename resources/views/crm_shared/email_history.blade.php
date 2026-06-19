<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Email History</strong>

        <a href="{{ $emailRoute }}" class="btn btn-sm btn-primary">
            Send Email
        </a>
    </div>

    <div class="list-group list-group-flush">
        @forelse($model->emailLogs as $email)
            <div class="list-group-item">
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>{{ $email->subject }}</strong>
                        <div class="small text-muted">
                            To: {{ $email->to_name }} &lt;{{ $email->to_email }}&gt;
                        </div>
                        <div class="small text-muted">
                            Sent: {{ $email->sent_at?->format('m/d/Y h:i A') }}
                        </div>
                    </div>

                    <span class="badge bg-success">
                        {{ $email->status }}
                    </span>
                </div>

                <div class="mt-3 border rounded p-3 bg-light">
                    {!! nl2br(e($email->body)) !!}
                </div>
            </div>
        @empty
            <div class="list-group-item text-muted">
                No emails sent yet.
            </div>
        @endforelse
    </div>
</div>
