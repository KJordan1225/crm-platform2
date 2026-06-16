@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Leads</h1>
        <a href="{{ route('leads.create') }}" class="btn btn-primary">New Lead</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <x-crm.search-form
        :action="route('leads.index')"
        placeholder="Search leads by name, company, email, or phone..."
    >
        <x-crm.select-filter
            name="status"
            label="Status"
            default="All Statuses"
            :options="$statuses"
            class="col-md-2"
        />
        <x-crm.select-filter
            name="source"
            label="Source"
            default="All Sources"
            :options="$sources"
            class="col-md-2"
        />
        <x-crm.select-filter
            name="sales_team_id"
            label="Sales Team"
            default="All Teams"
            :options="$salesTeams->pluck('name', 'id')"
            class="col-md-2"
        />

        <div class="col-md-2">
            <div class="form-check mt-4">
                <input type="checkbox"
                    name="mine"
                    value="1"
                    class="form-check-input"
                    id="mine"
                    @checked(request()->boolean('mine'))>

                <label for="mine" class="form-check-label">
                    My Records
                </label>
            </div>
        </div>

    </x-crm.search-form>



    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Source</th>
                        <th>Estimated Value</th>
                        <th>Owner</th>
                        <th>Team</th>
                        <th width="320">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr>
                            <td>{{ $lead->full_name }}</td>
                            <td>{{ $lead->company }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $lead->status }}</span>
                            </td>
                            <td>{{ $lead->source }}</td>
                            <td>${{ number_format($lead->estimated_value, 2) }}</td>
                            <td>{{ $lead->owner->name ?? 'None' }}</td>
                            <td>{{ $lead->salesTeam->name ?? 'None' }}</td>
                            <td>
                                <a href="{{ route('leads.show', $lead) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-sm btn-warning">Edit</a>

                                @if($lead->status !== 'Converted')
                                    <form action="{{ route('leads.convert', $lead) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button onclick="return confirm('Convert this lead?')" class="btn btn-sm btn-success">
                                            Convert
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this lead?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No leads found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $leads->links() }}
        </div>
    </div>
</div>
@endsection
