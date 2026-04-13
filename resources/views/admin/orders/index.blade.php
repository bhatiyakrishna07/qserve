@extends('admin.layouts.app')
@section('title', 'Orders')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-receipt mr-2"></i> All Orders</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Order #</th>
                    <th>Table</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php
                    $badges = [
                        'pending'   => 'warning',
                        'confirmed' => 'info',
                        'preparing' => 'primary',
                        'served'    => 'success',
                        'cancelled' => 'danger',
                    ];
                    $badge = $badges[$order->status] ?? 'secondary';
                @endphp
                <tr>
                    <td><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $order->table->name }}</td>
                    <td>{{ $order->customer_name ?? 'Guest' }}</td>
                    <td>
                        <span class="badge badge-info">
                            {{ $order->orderItems->count() }} items
                        </span>
                    </td>
                    <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                    <td>
                        <span class="badge badge-{{ $badge }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="btn btn-info btn-xs">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('admin.orders.invoice', $order) }}"
                            target="_blank"
                            class="btn btn-success btn-xs ml-1">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        No orders yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $orders->links() }}
    </div>
</div>
@endsection