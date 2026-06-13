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

    @include('crm_shared.search_bar', [
        'action' => route('leads.index'),
        'placeholder' => 'Search leads...',
        'filters' => '
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    ' . collect($statuses)->map(function ($status) {
                        return '<option value="'.$status.'" '.(request('status') === $status ? 'selected' : '').'>'.$status.'</option>';
                    })->implode('') . '
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Source</label>
                <select name="source" class="form-select">
                    <option value="">All Sources</option>
                    ' . collect($sources)->map(function ($source) {
                        return '<option value="'.$source.'" '.(request('source') === $source ? 'selected' : '').'>'.$source.'</option>';
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
                        <th>Company</th>
                        <th>Status</th>
                        <th>Source</th>
                        <th>Estimated Value</th>
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
