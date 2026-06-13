@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="fw-bold">Reports</h1>
        <p class="text-muted">
            Sales pipeline, revenue, invoice aging, lead conversion, and account performance.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Open Pipeline</div>
                    <div class="stat-value">
                        ${{ number_format($pipelineValue, 2) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Closed Won</div>
                    <div class="stat-value">
                        ${{ number_format($closedWonValue, 2) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Revenue Collected</div>
                    <div class="stat-value">
                        ${{ number_format($totalRevenue, 2) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-label">Outstanding AR</div>
                    <div class="stat-value">
                        ${{ number_format($outstandingInvoices, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Pipeline by Stage</strong>
                </div>

                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Stage</th>
                                <th>Deals</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($opportunitiesByStage as $stage)
                                <tr>
                                    <td>{{ $stage->stage }}</td>
                                    <td>{{ $stage->total }}</td>
                                    <td>${{ number_format($stage->value ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No opportunity data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Lead Conversion</strong>
                </div>

                <div class="card-body">
                    <div class="display-5 fw-bold">
                        {{ number_format($conversionRate, 1) }}%
                    </div>

                    <p class="text-muted">
                        {{ $convertedLeadCount }} converted out of {{ $leadCount }} total leads.
                    </p>

                    <div class="progress" style="height: 24px;">
                        <div class="progress-bar"
                             role="progressbar"
                             style="width: {{ min($conversionRate, 100) }}%;">
                            {{ number_format($conversionRate, 1) }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Monthly Revenue</strong>
                </div>

                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($monthlyRevenue as $row)
                                <tr>
                                    <td>{{ $row->month }}/{{ $row->year }}</td>
                                    <td>${{ number_format($row->total, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">No revenue recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Top Accounts by Revenue</strong>
                </div>

                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Account</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($topAccounts as $account)
                                <tr>
                                    <td>{{ $account->name }}</td>
                                    <td>${{ number_format($account->payments_sum_amount ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">No account revenue yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <strong>Aging Invoices</strong>
        </div>

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Account</th>
                        <th>Due Date</th>
                        <th>Balance</th>
                        <th>Days Past Due</th>
                        <th>Bucket</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($agingInvoices as $row)
                        <tr>
                            <td>
                                <a href="{{ route('invoices.show', $row['invoice']) }}">
                                    {{ $row['invoice']->invoice_number }}
                                </a>
                            </td>
                            <td>{{ $row['invoice']->account?->name ?? 'N/A' }}</td>
                            <td>{{ $row['invoice']->due_date?->format('m/d/Y') }}</td>
                            <td>${{ number_format($row['invoice']->balance_due, 2) }}</td>
                            <td>{{ $row['days_past_due'] }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $row['bucket'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No outstanding invoices.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
