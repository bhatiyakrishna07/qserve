@extends('admin.layouts.app')
@section('title')
    Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
@endsection

@section('content')
<div class="row">

    {{-- Order Info --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-muted">Table</td>
                        <td><strong>{{ $order->table->name }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Customer</td>
                        <td><strong>{{ $order->customer_name ?? 'Guest' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Total</td>
                        <td><strong class="text-danger">₹{{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Placed At</td>
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    @if($order->notes)
                    <tr>
                        <td class="text-muted">Notes</td>
                        <td>{{ $order->notes }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-exchange-alt mr-2"></i> Update Status</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <select name="status" class="form-control">
                            @foreach(['pending','confirmed','preparing','served','cancelled'] as $status)
                                <option value="{{ $status }}"
                                    {{ $order->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-1"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list mr-2"></i> Ordered Items</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->foodItem->name }}</strong>
                                @if($item->notes)
                                    <br><small class="text-muted">{{ $item->notes }}</small>
                                @endif
                            </td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td><strong>₹{{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                            <td><strong class="text-danger">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Orders
        </a>

        <a href="{{ route('admin.orders.invoice', $order) }}"
            target="_blank"
            class="btn btn-success ml-2">
            <i class="fas fa-print mr-1"></i> Print Invoice
        </a>
    </div>

</div>
@endsection