@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Opportunities</h1>
        <a href="{{ route('opportunities.create') }}" class="btn btn-primary">New Opportunity</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <x-crm.search-form
        :action="route('opportunities.index')"
        placeholder="Search opportunities by name, account, or source..."
    >
        <x-crm.select-filter
            name="stage"
            label="Stage"
            default="All Stages"
            :options="$stages"
            class="col-md-4"
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
                        <th>Account</th>
                        <th>Amount</th>
                        <th>Stage</th>
                        <th>Probability</th>
                        <th>Close Date</th>
                        <th>Owner</th>
                        <th>Team</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opportunities as $opportunity)
                        <tr>
                            <td>{{ $opportunity->name }}</td>
                            <td>{{ $opportunity->account?->name ?? 'None' }}</td>
                            <td>${{ number_format($opportunity->amount, 2) }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $opportunity->stage }}</span>
                            </td>
                            <td>{{ $opportunity->probability }}%</td>
                            <td>{{ $opportunity->close_date }}</td>
                            <td>{{ $opportunity->owner->name ?? 'None' }}</td>
                            <td>{{ $opportunity->salesTeam->name ?? 'None' }}</td>
                            <td>
                                <a href="{{ route('opportunities.show', $opportunity) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('opportunities.edit', $opportunity) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('opportunities.destroy', $opportunity) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this opportunity?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No opportunities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $opportunities->links() }}
        </div>
    </div>
</div>
@endsection
