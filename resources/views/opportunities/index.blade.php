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

    @include('crm_shared.search_bar', [
        'action' => route('opportunities.index'),
        'placeholder' => 'Search opportunities...',
        'filters' => '
            <div class="col-md-4">
                <label class="form-label">Stage</label>
                <select name="stage" class="form-select">
                    <option value="">All Stages</option>
                    ' . collect($stages)->map(function ($stage) {
                        return '<option value="'.$stage.'" '.(request('stage') === $stage ? 'selected' : '').'>'.$stage.'</option>';
                    })->implode('') . '
                </select>
            </div>
        '
    ])


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
