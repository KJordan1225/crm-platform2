@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">{{ $salesTeam->name }}</h1>
            <p class="text-muted mb-0">
                Manager: {{ $salesTeam->manager?->name ?? 'Unassigned' }}
            </p>
        </div>

        <a href="{{ route('sales-teams.edit', $salesTeam) }}" class="btn btn-warning">
            Edit Team
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
                    <div class="stat-value">{{ $salesTeam->members->count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Accounts</div>
                    <div class="stat-value">{{ $salesTeam->accounts->count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Leads</div>
                    <div class="stat-value">{{ $salesTeam->leads->count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Opportunities</div>
                    <div class="stat-value">{{ $salesTeam->opportunities->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Team Details</strong>
                </div>

                <div class="card-body">
                    <p><strong>Status:</strong> {{ $salesTeam->is_active ? 'Active' : 'Inactive' }}</p>
                    <p><strong>Description:</strong></p>
                    <p>{{ $salesTeam->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Add Team Member</strong>
                </div>

                <div class="card-body">
                    <form action="{{ route('sales-teams.members.store', $salesTeam) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">User</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} — {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Team Role</label>
                            <select name="role" class="form-select">
                                <option value="Sales Rep">Sales Rep</option>
                                <option value="Account Executive">Account Executive</option>
                                <option value="Sales Manager">Sales Manager</option>
                                <option value="Sales Development Rep">Sales Development Rep</option>
                                <option value="Customer Success">Customer Success</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Joined Date</label>
                            <input type="date"
                                   name="joined_at"
                                   class="form-control"
                                   value="{{ now()->toDateString() }}">
                        </div>

                        <div class="form-check mb-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   class="form-check-input"
                                   id="member_is_active"
                                   checked>

                            <label for="member_is_active" class="form-check-label">
                                Active Member
                            </label>
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
            <strong>Team Members</strong>
        </div>

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Team Role</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($salesTeam->members as $member)
                        <tr>
                            <td>{{ $member->user?->name }}</td>
                            <td>{{ $member->user?->email }}</td>
                            <td>{{ $member->role }}</td>
                            <td>{{ $member->joined_at?->format('m/d/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $member->is_active ? 'success' : 'secondary' }}">
                                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('sales-team-members.destroy', $member) }}" method="POST">
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
                            <td colspan="6">No team members yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
