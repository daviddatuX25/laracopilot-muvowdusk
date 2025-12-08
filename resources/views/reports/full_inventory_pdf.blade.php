<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Full Inventory Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { width: 100%; overflow-x: hidden; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            width: 100%;
            overflow-x: hidden;
            padding: 0.5in;
            max-width: 7.5in;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .summary {
            margin: 15px 0;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin: 15px 0;
        }
        .summary-item {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        }
        .summary-item label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .summary-item value {
            font-size: 18px;
            color: #0066cc;
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .status-normal {
            background-color: #e6ffe6;
            color: #006600;
        }
        .status-low {
            background-color: #ffffcc;
            color: #999900;
        }
        .status-out {
            background-color: #ffe6e6;
            color: #cc0000;
        }
    </style>
</head>
<body>
    <h1>Full Inventory Report</h1>
    <p class="summary">Generated on {{ date('Y-m-d H:i:s') }}</p>

    <div class="summary-grid">
        <div class="summary-item">
            <label>Total Products</label>
            <value>{{ $totalProducts }}</value>
        </div>
        <div class="summary-item">
            <label>Total Stock Units</label>
            <value>{{ $totalStock }}</value>
        </div>
        <div class="summary-item">
            <label>Total Inventory Value</label>
            <value>₱{{ number_format($totalValue, 2) }}</value>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Barcode</th>
                <th>Category</th>
                <th>Supplier</th>
                <th class="text-right">Cost Price</th>
                <th class="text-right">Sell Price</th>
                <th class="text-center">Stock</th>
                <th class="text-center">Reorder Lvl</th>
                <th class="text-right">Total Value</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                @php
                    $totalValue = $product->current_stock * $product->cost_price;
                    $statusClass = $product->current_stock <= 0
                        ? 'status-out'
                        : ($product->current_stock <= $product->reorder_level
                            ? 'status-low'
                            : 'status-normal');
                    $statusText = $product->current_stock <= 0
                        ? 'Out'
                        : ($product->current_stock <= $product->reorder_level
                            ? 'Low'
                            : 'OK');
                @endphp
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->barcode ?? '-' }}</td>
                    <td>{{ $product->category?->name ?? 'N/A' }}</td>
                    <td>{{ $product->supplier?->name ?? 'N/A' }}</td>
                    <td class="text-right">₱{{ number_format($product->cost_price, 2) }}</td>
                    <td class="text-right">₱{{ number_format($product->selling_price, 2) }}</td>
                    <td class="text-center">{{ $product->current_stock }}</td>
                    <td class="text-center">{{ $product->reorder_level }}</td>
                    <td class="text-right">₱{{ number_format($totalValue, 2) }}</td>
                    <td class="text-center {{ $statusClass }}">{{ $statusText }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center;">No products found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
