<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Restock Plan #{{ $restock->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { width: 100%; overflow-x: hidden; }
        body { font-family: DejaVu Sans, sans-serif; color: #333; width: 100%; overflow-x: hidden; }
        .container { max-width: 7.5in; margin: 0 auto; padding: 0.5in; width: 100%; box-sizing: border-box; }
        .header { margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 20px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; word-wrap: break-word; }
        .header .meta { font-size: 11px; color: #666; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin: 20px 0; }
        .info-box { background: #f5f5f5; padding: 12px; border-radius: 3px; word-wrap: break-word; }
        .info-box h3 { font-size: 11px; text-transform: uppercase; color: #666; margin-bottom: 5px; }
        .info-box .value { font-size: 14px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 12px; }
        th { background: #f5f5f5; padding: 8px; text-align: left; font-weight: bold; border-bottom: 1px solid #ddd; word-wrap: break-word; }
        td { padding: 8px; border-bottom: 1px solid #eee; word-wrap: break-word; }
        .total-section { margin-top: 15px; padding-top: 15px; border-top: 2px solid #000; }
        .total-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 13px; }
        .total-row.grand-total { font-size: 16px; font-weight: bold; margin-top: 8px; }
        .budget-status { padding: 12px; background: #f0f0f0; border-radius: 3px; margin-top: 15px; }
        .budget-status h3 { margin-bottom: 8px; font-size: 13px; }
        .notes { margin-top: 15px; padding: 12px; background: #fffbf0; border-left: 3px solid #ff9800; font-size: 12px; word-wrap: break-word; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>RESTOCK PLAN #{{ $restock->id }}</h1>
            <div class="meta">{{ $type === 'receipt' ? 'RECEIPT' : 'PRE-PURCHASE GUIDANCE' }}</div>
            <div class="meta">Created: {{ $restock->created_at->format('M d, Y H:i A') }}</div>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <h3>Inventory</h3>
                <div class="value">{{ $inventory->name }}</div>
            </div>
            <div class="info-box">
                <h3>Status</h3>
                <div class="value">{{ strtoupper($restock->status) }}</div>
            </div>
        </div>

        <h2 style="margin-top: 30px; margin-bottom: 15px;">Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: right;">Unit Cost</th>
                    <th style="text-align: right;">Subtotal</th>
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
                <span>Cart Total:</span>
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
                <span>TOTAL COST:</span>
                <span>₱{{ number_format($restock->total_cost, 2) }}</span>
            </div>
        </div>

        <div class="budget-status">
            <h3>Budget Analysis</h3>
            <div class="total-row">
                <span>Budget Amount:</span>
                <span>₱{{ number_format($restock->budget_amount, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Status:</span>
                <strong>
                    @if($restock->budget_status === 'over')
                        Surplus
                    @elseif($restock->budget_status === 'under')
                        Shortage
                    @elseif($restock->budget_status === 'fit')
                        Perfect Match
                    @endif
                </strong>
            </div>
            <div class="total-row">
                <span>
                    @if($restock->budget_status === 'over')
                        Shortage:
                    @else
                        Surplus:
                    @endif
                </span>
                <span>₱{{ number_format(abs($restock->budget_difference), 2) }}</span>
            </div>
        </div>

        @if($restock->notes)
            <div class="notes">
                <strong>Notes:</strong>
                <p>{{ $restock->notes }}</p>
            </div>
        @endif

        @if($type === 'receipt' && $restock->fulfilled_at)
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; color: #666; font-size: 12px;">
                <p>Fulfilled on: {{ $restock->fulfilled_at->format('M d, Y H:i A') }}</p>
                <p>By: {{ $restock->fulfilledBy?->name ?? 'System' }}</p>
            </div>
        @endif
    </div>
</body>
</html>
