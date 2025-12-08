<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Restock Receipt #{{ $restock->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { width: 100%; overflow-x: hidden; }
        body { font-family: DejaVu Sans, sans-serif; color: #333; width: 100%; overflow-x: hidden; }
        .container { max-width: 7.5in; margin: 0 auto; padding: 0.5in; width: 100%; box-sizing: border-box; }
        .header { margin-bottom: 25px; border-bottom: 2px solid #000; padding-bottom: 15px; text-align: center; }
        .header h1 { font-size: 22px; margin-bottom: 5px; }
        .header .badge { display: inline-block; background: #4CAF50; color: white; padding: 4px 12px; border-radius: 3px; margin-top: 8px; font-weight: bold; font-size: 12px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin: 15px 0; }
        .info-box { background: #f5f5f5; padding: 10px; border-radius: 3px; word-wrap: break-word; }
        .info-box h3 { font-size: 10px; text-transform: uppercase; color: #666; margin-bottom: 4px; }
        .info-box .value { font-size: 12px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 12px 0; font-size: 11px; }
        th { background: #f5f5f5; padding: 7px; text-align: left; font-weight: bold; border-bottom: 1px solid #ddd; word-wrap: break-word; }
        td { padding: 7px; border-bottom: 1px solid #eee; word-wrap: break-word; }
        .total-section { margin-top: 12px; padding-top: 12px; border-top: 2px solid #000; }
        .total-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 12px; }
        .total-row.grand-total { font-size: 15px; font-weight: bold; margin-top: 8px; }
        .verification { margin-top: 20px; padding: 12px; background: #e8f5e9; border: 1px solid #4CAF50; border-radius: 3px; text-align: center; font-size: 11px; }
        .verification h3 { color: #2e7d32; margin-bottom: 5px; font-size: 12px; }
        .signature-line { margin-top: 25px; display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .signature-box { text-align: center; }
        .signature-box .line { border-top: 1px solid #000; width: 100%; margin: 20px 0 3px 0; }
        .signature-box .label { font-size: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>RESTOCK RECEIPT</h1>
            <div style="font-size: 16px; color: #666; margin-top: 5px;">Plan #{{ $restock->id }}</div>
            <div class="badge">✓ FULFILLED</div>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <h3>Inventory</h3>
                <div class="value">{{ $inventory->name }}</div>
            </div>
            <div class="info-box">
                <h3>Fulfilled Date</h3>
                <div class="value">{{ $restock->fulfilled_at->format('M d, Y') }}</div>
            </div>
            <div class="info-box">
                <h3>Created Date</h3>
                <div class="value">{{ $restock->created_at->format('M d, Y') }}</div>
            </div>
            <div class="info-box">
                <h3>Fulfilled By</h3>
                <div class="value">{{ $restock->fulfilledBy?->name ?? 'System' }}</div>
            </div>
        </div>

        <h2 style="margin-top: 30px; margin-bottom: 15px;">Items Received</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: right;">Unit Cost</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td style="text-align: center;">{{ $item->quantity_requested }}</td>
                        <td style="text-align: right;">₱{{ number_format($item->unit_cost, 2) }}</td>
                        <td style="text-align: right; font-weight: bold;">₱{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>₱{{ number_format($restock->cart_total, 2) }}</span>
            </div>
            @if($restock->tax_percentage > 0)
                <div class="total-row">
                    <span>Tax ({{ $restock->tax_percentage }}%):</span>
                    <span>₱{{ number_format($restock->tax_amount, 2) }}</span>
                </div>
            @endif
            @if($restock->shipping_fee > 0)
                <div class="total-row">
                    <span>Shipping:</span>
                    <span>₱{{ number_format($restock->shipping_fee, 2) }}</span>
                </div>
            @endif
            @if($restock->labor_fee > 0)
                <div class="total-row">
                    <span>Labor:</span>
                    <span>₱{{ number_format($restock->labor_fee, 2) }}</span>
                </div>
            @endif
            @if($restock->other_fees)
                @foreach($restock->other_fees as $fee)
                    @if(!empty($fee['label']) && $fee['amount'] > 0)
                        <div class="total-row">
                            <span>{{ $fee['label'] }}:</span>
                            <span>₱{{ number_format($fee['amount'], 2) }}</span>
                        </div>
                    @endif
                @endforeach
            @endif
            <div class="total-row grand-total">
                <span>TOTAL AMOUNT PAID:</span>
                <span>₱{{ number_format($restock->total_cost, 2) }}</span>
            </div>
        </div>

        <div class="verification">
            <h3>✓ Verification Complete</h3>
            <p>All items have been received and stock levels have been updated.</p>
            <p style="font-size: 12px; color: #666; margin-top: 10px;">
                Items added: {{ $items->count() }} | Total units: {{ $items->sum('quantity_requested') }}
            </p>
        </div>

        @if($restock->notes)
            <div style="margin-top: 20px; padding: 15px; background: #fff3e0; border-left: 4px solid #ff9800;">
                <strong>Notes:</strong>
                <p style="margin-top: 5px;">{{ $restock->notes }}</p>
            </div>
        @endif

        <div class="signature-line">
            <div class="signature-box">
                <div class="line"></div>
                <div class="label">Received By (Print Name)</div>
            </div>
            <div class="signature-box">
                <div class="line"></div>
                <div class="label">Date & Time</div>
            </div>
        </div>

        <div style="margin-top: 40px; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #ddd; padding-top: 10px;">
            <p>This is an official receipt. Please retain for your records.</p>
            <p>Generated: {{ now()->format('M d, Y H:i A') }}</p>
        </div>
    </div>
</body>
</html>
