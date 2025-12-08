<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Stock Movement History</title>
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
            font-size: 18px;
            margin-bottom: 10px;
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
    </style>
</head>
<body>
    <h1>Stock Movement History Report</h1>
    <p style="text-align: center; color: #666;">Generated on {{ date('Y-m-d H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Movement Type</th>
                <th>Quantity</th>
                <th>Reference</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $movement)
                <tr>
                    <td>{{ $movement->product->name ?? 'N/A' }}</td>
                    <td>{{ $movement->product->sku ?? 'N/A' }}</td>
                    <td>{{ ucfirst($movement->type) }}</td>
                    <td>{{ $movement->quantity }}</td>
                    <td>{{ $movement->reference ?? 'N/A' }}</td>
                    <td>{{ $movement->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No movement history found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
