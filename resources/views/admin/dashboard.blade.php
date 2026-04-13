@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Stats Cards --}}
<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pending_orders }}</h3>
                <p>Pending Orders</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
            <a href="{{ route('admin.orders.index') }}" class="small-box-footer">View Orders <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $total_orders }}</h3>
                <p>Total Orders</p>
            </div>
            <div class="icon"><i class="fas fa-receipt"></i></div>
            <a href="{{ route('admin.orders.index') }}" class="small-box-footer">View Orders <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $total_food_items }}</h3>
                <p>Food Items</p>
            </div>
            <div class="icon"><i class="fas fa-burger"></i></div>
            <a href="{{ route('admin.food-items.index') }}" class="small-box-footer">View Items <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $total_tables }}</h3>
                <p>Total Tables</p>
            </div>
            <div class="icon"><i class="fas fa-chair"></i></div>
            <a href="{{ route('admin.tables.index') }}" class="small-box-footer">View Tables <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

</div>

{{-- Recent Orders --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-receipt mr-2"></i> Recent Orders
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Table</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->table->name }}</td>
                            <td>{{ $order->customer_name ?? 'Guest' }}</td>
                            <td>₹{{ number_format($order->total_amount, 2) }}</td>
                            <td>
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
                                <span class="badge badge-{{ $badge }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                No orders yet
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection