<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed!</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Nunito',sans-serif; background:#f5f5f5;
               min-height:100vh; padding:20px; }
        .container { max-width:480px; margin:0 auto; }

        .success-card {
            background:white; border-radius:16px;
            overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.1);
            margin-bottom:16px;
        }
        .success-header {
            background:linear-gradient(135deg,#28a745,#20c256);
            color:white; padding:30px 20px; text-align:center;
        }
        .success-icon { font-size:3.5rem; margin-bottom:10px; }
        .success-header h2 { font-size:1.5rem; font-weight:800; margin-bottom:4px; }
        .success-header p { opacity:0.9; font-size:0.9rem; }

        .order-details { padding:20px; }
        .detail-row {
            display:flex; justify-content:space-between;
            padding:8px 0; border-bottom:1px solid #f5f5f5;
            font-size:0.9rem;
        }
        .detail-row:last-child { border-bottom:none; }
        .detail-label { color:#888; }
        .detail-value { font-weight:700; color:#333; }

        .items-card {
            background:white; border-radius:16px;
            overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.1);
            margin-bottom:16px;
        }
        .items-header {
            background:#f8f9fa; padding:12px 20px;
            font-weight:800; font-size:0.95rem; color:#333;
            border-bottom:1px solid #eee;
        }
        .order-item {
            display:flex; justify-content:space-between;
            align-items:center; padding:12px 20px;
            border-bottom:1px solid #f5f5f5;
        }
        .order-item:last-child { border-bottom:none; }
        .order-item-name { font-weight:700; font-size:0.9rem; color:#333; }
        .order-item-qty { font-size:0.8rem; color:#888; }
        .order-item-price { font-weight:800; color:#e8451e; }

        .total-card {
            background:linear-gradient(135deg,#e8451e,#ff6b3d);
            color:white; border-radius:16px;
            padding:16px 20px;
            display:flex; justify-content:space-between; align-items:center;
            margin-bottom:16px;
            box-shadow:0 4px 20px rgba(232,69,30,0.3);
        }
        .total-label { font-size:0.9rem; opacity:0.9; }
        .total-amount { font-size:1.5rem; font-weight:800; }

        .status-badge {
            display:inline-block; padding:4px 12px; border-radius:20px;
            font-size:0.8rem; font-weight:700;
            background:#fff3cd; color:#856404;
        }

        .info-box {
            background:#e8f4fd; border-radius:12px;
            padding:14px 16px; text-align:center;
            color:#0c63a4; font-size:0.85rem; font-weight:600;
        }
    </style>
</head>
<body>
<div class="container">

    {{-- Success Header --}}
    <div class="success-card">
        <div class="success-header">
            <div class="success-icon">🎉</div>
            @if(session('order_updated'))
                <h2>Items Added!</h2>
                <p>Your new items have been added to your existing order!</p>
            @else
                <h2>Order Placed!</h2>
                <p>Your order has been received. We'll prepare it shortly!</p>
            @endif
        </div>
        <div class="order-details">
            <div class="detail-row">
                <span class="detail-label">Order #</span>
                <span class="detail-value">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Table</span>
                <span class="detail-value">{{ $order->table->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Customer</span>
                <span class="detail-value">{{ $order->customer_name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                    <span class="status-badge">⏳ {{ ucfirst($order->status) }}</span>
                </span>
            </div>
            @if($order->notes)
            <div class="detail-row">
                <span class="detail-label">Notes</span>
                <span class="detail-value">{{ $order->notes }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Order Items --}}
    <div class="items-card">
        <div class="items-header">
            <i class="fas fa-receipt mr-2"></i> Order Items
        </div>
        @foreach($order->orderItems as $item)
        <div class="order-item">
            <div>
                <div class="order-item-name">{{ $item->foodItem->name }}</div>
                <div class="order-item-qty">
                    ₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}
                </div>
            </div>
            <div class="order-item-price">
                ₹{{ number_format($item->price * $item->quantity, 2) }}
            </div>
        </div>
        @endforeach
    </div>

    {{-- Total --}}
    <div class="total-card">
        <div>
            <div class="total-label">Total Amount</div>
        </div>
        <div class="total-amount">
            ₹{{ number_format($order->total_amount, 2) }}
        </div>
    </div>

    {{-- Info --}}
    <div class="info-box">
        <i class="fas fa-info-circle mr-1"></i>
        Please wait at your table. Our staff will serve you shortly!
    </div>

</div>
</body>
</html>