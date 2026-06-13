@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">Sales Orders</h1>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Account</th>
                        <th>Quote</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesOrders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->account?->name ?? 'N/A' }}</td>
                            <td>{{ $order->quote?->quote_number ?? 'N/A' }}</td>
                            <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
                            <td>${{ number_format($order->grand_total, 2) }}</td>
                            <td>
                                <a href="{{ route('sales-orders.show', $order) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No sales orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{ $salesOrders->links() }}
        </div>
    </div>
</div>
@endsection
