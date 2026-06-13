@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">Campaigns</h1>
            <p class="text-muted">Track marketing campaigns, responses, conversions, and ROI.</p>
        </div>

        <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
            New Campaign
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Members</th>
                        <th>Budget</th>
                        <th>Actual Cost</th>
                        <th>Expected Revenue</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign->name }}</td>
                            <td>{{ $campaign->type }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $campaign->status }}</span>
                            </td>
                            <td>{{ $campaign->members_count }}</td>
                            <td>${{ number_format($campaign->budgeted_cost, 2) }}</td>
                            <td>${{ number_format($campaign->actual_cost, 2) }}</td>
                            <td>${{ number_format($campaign->expected_revenue, 2) }}</td>
                            <td>
                                <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this campaign?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No campaigns found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $campaigns->links() }}
        </div>
    </div>
</div>
@endsection
