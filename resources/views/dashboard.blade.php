@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="fw-bold">Dashboard</h1>
        <p class="text-muted">
            Salesforce-style CRM overview for sales pipeline, leads, accounts, and opportunities.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Accounts</div>
                    <div class="stat-value">{{ $totalAccounts }}</div>
                    <a href="{{ route('accounts.index') }}" class="small">View accounts</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Contacts</div>
                    <div class="stat-value">{{ $totalContacts }}</div>
                    <a href="{{ route('contacts.index') }}" class="small">View contacts</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Leads</div>
                    <div class="stat-value">{{ $totalLeads }}</div>
                    <a href="{{ route('leads.index') }}" class="small">View leads</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Opportunities</div>
                    <div class="stat-value">{{ $totalOpportunities }}</div>
                    <a href="{{ route('opportunities.index') }}" class="small">View opportunities</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Open Pipeline Value</div>
                    <div class="stat-value">
                        ${{ number_format($pipelineValue, 2) }}
                    </div>
                    <p class="text-muted mb-0">
                        Includes all opportunities except Closed Lost.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Closed Won Revenue</div>
                    <div class="stat-value">
                        ${{ number_format($wonValue, 2) }}
                    </div>
                    <p class="text-muted mb-0">
                        Total revenue from won deals.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Pipeline by Stage</strong>
                </div>

                <div class="card-body">
                    @forelse($opportunitiesByStage as $stage)
                        <div class="pipeline-stage bg-white border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $stage->stage }}</strong>
                                    <div class="text-muted small">
                                        {{ $stage->total }} deal(s)
                                    </div>
                                </div>

                                <div class="fw-bold">
                                    ${{ number_format($stage->value ?? 0, 2) }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No pipeline data yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <strong>Open Opportunities</strong>
                </div>

                <div class="list-group list-group-flush">
                    @forelse($openOpportunities as $opportunity)
                        <a href="{{ route('opportunities.show', $opportunity) }}" class="list-group-item list-group-item-action">
                            <div class="fw-bold">{{ $opportunity->name }}</div>
                            <div class="small text-muted">
                                {{ $opportunity->stage }} —
                                ${{ number_format($opportunity->amount, 2) }}
                            </div>
                        </a>
                    @empty
                        <div class="list-group-item text-muted">
                            No open opportunities.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Recent Leads</strong>
                </div>

                <div class="list-group list-group-flush">
                    @forelse($recentLeads as $lead)
                        <a href="{{ route('leads.show', $lead) }}" class="list-group-item list-group-item-action">
                            <div class="fw-bold">{{ $lead->full_name }}</div>
                            <div class="small text-muted">
                                {{ $lead->company }} —
                                {{ $lead->status }}
                            </div>
                        </a>
                    @empty
                        <div class="list-group-item text-muted">
                            No recent leads.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
