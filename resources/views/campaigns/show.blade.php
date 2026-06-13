@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">{{ $campaign->name }}</h1>
            <p class="text-muted mb-0">
                {{ $campaign->type }} campaign — {{ $campaign->status }}
            </p>
        </div>

        <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-warning">
            Edit Campaign
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Fix the following errors:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Members</div>
                    <div class="stat-value">{{ $campaign->members->count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Responses</div>
                    <div class="stat-value">
                        {{ $campaign->members->whereIn('status', ['Responded', 'Interested', 'Converted'])->count() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Converted</div>
                    <div class="stat-value">
                        {{ $campaign->members->where('status', 'Converted')->count() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">ROI</div>
                    <div class="stat-value">
                        {{ number_format($campaign->roi, 1) }}%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Campaign Details</strong>
                </div>

                <div class="card-body">
                    <p><strong>Start Date:</strong> {{ $campaign->start_date?->format('m/d/Y') ?? 'N/A' }}</p>
                    <p><strong>End Date:</strong> {{ $campaign->end_date?->format('m/d/Y') ?? 'N/A' }}</p>
                    <p><strong>Budgeted Cost:</strong> ${{ number_format($campaign->budgeted_cost, 2) }}</p>
                    <p><strong>Actual Cost:</strong> ${{ number_format($campaign->actual_cost, 2) }}</p>
                    <p><strong>Expected Revenue:</strong> ${{ number_format($campaign->expected_revenue, 2) }}</p>
                    <p><strong>Description:</strong></p>
                    <p>{{ $campaign->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Add Campaign Member</strong>
                </div>

                <div class="card-body">
                    <form action="{{ route('campaign-members.store', $campaign) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Member Type</label>
                            <select name="member_type" class="form-select" required>
                                <option value="lead">Lead</option>
                                <option value="contact">Contact</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lead or Contact ID</label>
                            <input type="number" name="member_id" class="form-control" required>
                            <div class="form-text">
                                Use the Lead ID or Contact ID from the lists below.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Initial Status</label>
                            <select name="status" class="form-select">
                                @foreach(['Sent', 'Opened', 'Responded', 'Interested', 'Converted', 'Unsubscribed'] as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary w-100">
                            Add Member
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <strong>Campaign Members</strong>
        </div>

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th width="280">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($campaign->members as $member)
                        <tr>
                            <td>{{ class_basename($member->memberable_type) }}</td>
                            <td>
                                @if($member->memberable)
                                    {{ $member->memberable->full_name ?? $member->memberable->name ?? 'Unknown' }}
                                @else
                                    Missing Record
                                @endif
                            </td>
                            <td>{{ $member->memberable->email ?? '' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $member->status }}</span>
                            </td>
                            <td>
                                <form action="{{ route('campaign-members.update', $member) }}" method="POST" class="d-inline-flex gap-2">
                                    @csrf
                                    @method('PUT')

                                    <select name="status" class="form-select form-select-sm">
                                        @foreach(['Sent', 'Opened', 'Responded', 'Interested', 'Converted', 'Unsubscribed'] as $status)
                                            <option value="{{ $status }}" @selected($member->status === $status)>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button class="btn btn-sm btn-success">
                                        Update
                                    </button>
                                </form>

                                <form action="{{ route('campaign-members.destroy', $member) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Remove this member?')" class="btn btn-sm btn-danger">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No campaign members yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Available Leads</strong>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Company</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $lead)
                                <tr>
                                    <td>{{ $lead->id }}</td>
                                    <td>{{ $lead->full_name }}</td>
                                    <td>{{ $lead->company }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Available Contacts</strong>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Account</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>{{ $contact->full_name }}</td>
                                    <td>{{ $contact->account?->name ?? 'None' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
