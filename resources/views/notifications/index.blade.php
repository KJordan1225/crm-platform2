@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">Notifications</h1>
            <p class="text-muted">CRM alerts for leads, opportunities, and tasks.</p>
        </div>

        <form action="{{ route('notifications.read-all') }}" method="POST">
            @csrf
            <button class="btn btn-outline-primary">
                Mark All Read
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="list-group list-group-flush">
            @forelse($notifications as $notification)
                <div class="list-group-item {{ $notification->read_at ? '' : 'bg-light' }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>
                                {{ $notification->data['message'] ?? 'CRM Notification' }}
                            </strong>

                            <div class="small text-muted">
                                {{ $notification->created_at->format('m/d/Y h:i A') }}
                            </div>

                            @if(!empty($notification->data['url']))
                                <a href="{{ $notification->data['url'] }}" class="btn btn-sm btn-primary mt-2">
                                    View Record
                                </a>
                            @endif
                        </div>

                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-success">
                                    Mark Read
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="list-group-item text-muted">
                    No notifications found.
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
