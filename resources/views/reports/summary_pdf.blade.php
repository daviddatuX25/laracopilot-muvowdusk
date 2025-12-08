<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Inventory Summary Report</title>
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
        .summary-box {
            margin: 12px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <h1>Inventory Summary Report</h1>
    <p style="text-align: center; color: #666;">Generated on {{ date('Y-m-d H:i:s') }}</p>

    <div class="summary-box">
        <div class="summary-row">
            <strong>Total Products:</strong>
            <span>{{ $totalProducts }}</span>
        </div>
        <div class="summary-row">
            <strong>Total Categories:</strong>
            <span>{{ $totalCategories }}</span>
        </div>
        <div class="summary-row">
            <strong>Total Suppliers:</strong>
            <span>{{ $totalSuppliers }}</span>
        </div>
        <div class="summary-row">
            <strong>Total Stock Value:</strong>
            <span>₱{{ number_format($totalStockValue, 2) }}</span>
        </div>
    </div>
</body>
</html>
