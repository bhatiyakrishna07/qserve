<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f5f5f5;
            padding: 20px;
            color: #333;
        }

        .invoice-wrapper {
            max-width: 720px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        /* Header */
        .invoice-header {
            background: linear-gradient(135deg, #e8451e, #ff6b3d);
            color: white;
            padding: 30px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand-name {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 1px;
        }
        .brand-tagline {
            font-size: 0.85rem;
            opacity: 0.85;
            margin-top: 2px;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h2 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 2px;
        }
        .invoice-title p {
            font-size: 0.85rem;
            opacity: 0.85;
        }

        /* Info Section */
        .invoice-info {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0;
            border-bottom: 2px solid #f0f0f0;
        }
        .info-box {
            padding: 20px 30px;
            border-right: 1px solid #f0f0f0;
        }
        .info-box:last-child { border-right: none; }
        .info-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            margin-bottom: 6px;
        }
        .info-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #333;
        }
        .info-value.highlight {
            color: #e8451e;
            font-size: 1.05rem;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .status-pending   { background:#fff3cd; color:#856404; }
        .status-confirmed { background:#cff4fc; color:#0c5460; }
        .status-preparing { background:#cce5ff; color:#004085; }
        .status-served    { background:#d4edda; color:#155724; }
        .status-cancelled { background:#f8d7da; color:#721c24; }

        /* Items Table */
        .items-section { padding: 30px 40px; }
        .items-section h3 {
            font-size: 1rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e8451e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            background: #2d2d2d;
            color: white;
        }
        thead th {
            padding: 10px 14px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tbody tr { border-bottom: 1px solid #f0f0f0; }
        tbody tr:hover { background: #fafafa; }
        tbody td {
            padding: 12px 14px;
            font-size: 0.9rem;
        }
        .item-name { font-weight: 700; }
        .item-note { font-size:0.75rem; color:#888; margin-top:2px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Totals */
        .totals-section {
            padding: 0 40px 30px;
            display: flex;
            justify-content: flex-end;
        }
        .totals-box { width: 280px; }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 0.9rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .total-row.grand {
            border-bottom: none;
            border-top: 2px solid #e8451e;
            margin-top: 4px;
            padding-top: 12px;
        }
        .total-row.grand .label {
            font-size: 1rem;
            font-weight: 800;
            color: #333;
        }
        .total-row.grand .amount {
            font-size: 1.2rem;
            font-weight: 800;
            color: #e8451e;
        }

        /* Notes */
        .notes-section {
            margin: 0 40px 30px;
            background: #fff8f6;
            border-left: 4px solid #e8451e;
            padding: 12px 16px;
            border-radius: 0 8px 8px 0;
        }
        .notes-section .notes-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #e8451e;
            margin-bottom: 4px;
        }
        .notes-section p { font-size:0.9rem; color:#555; }

        /* Footer */
        .invoice-footer {
            background: #f8f9fa;
            padding: 20px 40px;
            text-align: center;
            border-top: 2px solid #f0f0f0;
        }
        .invoice-footer p {
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 4px;
        }
        .invoice-footer .thank-you {
            font-size: 1rem;
            font-weight: 800;
            color: #e8451e;
        }

        /* Print Button */
        .print-actions {
            max-width: 720px;
            margin: 16px auto;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .btn-print {
            background: #e8451e;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
        }
        .btn-back {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            text-decoration: none;
        }

        /* Print Styles */
        @media print {
            body { background: white; padding: 0; }
            .print-actions { display: none; }
            .invoice-wrapper {
                box-shadow: none;
                border-radius: 0;
            }
            @page {
                margin: 10mm;
                size: A4;
            }
        }
    </style>
</head>
<body>

{{-- Print / Back Buttons --}}
<div class="print-actions">
    <a href="{{ route('admin.orders.show', $order) }}" class="btn-back">
        ← Back
    </a>
    <button class="btn-print" onclick="window.print()">
        🖨️ Print Invoice
    </button>
</div>

<div class="invoice-wrapper">

    {{-- Header --}}
    <div class="invoice-header">
        <div>
            <div class="brand-name">🍽️ QServe</div>
            <div class="brand-tagline">Restaurant Management System</div>
        </div>
        <div class="invoice-title">
            <h2>INVOICE</h2>
            <p>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
            <p>{{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    {{-- Info --}}
    <div class="invoice-info">
        <div class="info-box">
            <div class="info-label">Table</div>
            <div class="info-value highlight">{{ $order->table->name }}</div>
            <div style="font-size:0.8rem; color:#888; margin-top:2px;">
                Capacity: {{ $order->table->capacity }} persons
            </div>
        </div>
        <div class="info-box">
            <div class="info-label">Customer</div>
            <div class="info-value">{{ $order->customer_name ?? 'Guest' }}</div>
            @if($order->notes)
            <div style="font-size:0.8rem; color:#888; margin-top:2px;">
                Has special instructions
            </div>
            @endif
        </div>
        <div class="info-box">
            <div class="info-label">Status</div>
            <div class="info-value" style="margin-top:4px;">
                <span class="status-badge status-{{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div style="font-size:0.8rem; color:#888; margin-top:6px;">
                {{ $order->orderItems->count() }} item(s) ordered
            </div>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="items-section">
        <h3>📋 Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="item-name">{{ $item->foodItem->name }}</div>
                        @if($item->notes)
                            <div class="item-note">📝 {{ $item->notes }}</div>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                    <td class="text-right">
                        <strong>₹{{ number_format($item->price * $item->quantity, 2) }}</strong>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Totals --}}
    <div class="totals-section">
        <div class="totals-box">
            <div class="total-row">
                <span class="label" style="color:#888;">Subtotal</span>
                <span>₹{{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="total-row">
                <span class="label" style="color:#888;">Tax (0%)</span>
                <span>₹0.00</span>
            </div>
            <div class="total-row grand">
                <span class="label">Total</span>
                <span class="amount">₹{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Special Notes --}}
    @if($order->notes)
    <div class="notes-section">
        <div class="notes-label">Special Instructions</div>
        <p>{{ $order->notes }}</p>
    </div>
    @endif

    {{-- Footer --}}
    <div class="invoice-footer">
        <p class="thank-you">Thank you for dining with us! 🙏</p>
        <p>This is a computer generated invoice.</p>
        <p>{{ config('app.name') }} &copy; {{ date('Y') }}</p>
    </div>

</div>

</body>
</html>