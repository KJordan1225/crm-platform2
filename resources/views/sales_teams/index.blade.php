@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">Sales Teams</h1>
            <p class="text-muted">Manage sales teams, managers, and team performance.</p>
        </div>

        <a href="{{ route('sales-teams.create') }}" class="btn btn-primary">
            New Sales Team
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
                        <th>Team</th>
                        <th>Manager</th>
                        <th>Members</th>
                        <th>Accounts</th>
                        <th>Leads</th>
                        <th>Opportunities</th>
                        <th>Status</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($salesTeams as $team)
                        <tr>
                            <td>{{ $team->name }}</td>
                            <td>{{ $team->manager?->name ?? 'Unassigned' }}</td>
                            <td>{{ $team->members_count }}</td>
                            <td>{{ $team->accounts_count }}</td>
                            <td>{{ $team->leads_count }}</td>
                            <td>{{ $team->opportunities_count }}</td>
                            <td>
                                <span class="badge bg-{{ $team->is_active ? 'success' : 'secondary' }}">
                                    {{ $team->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('sales-teams.show', $team) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('sales-teams.edit', $team) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('sales-teams.destroy', $team) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this sales team?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No sales teams found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $salesTeams->links() }}
        </div>
    </div>
</div>
@endsection
