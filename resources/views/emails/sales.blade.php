<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report - {{ \Illuminate\Support\Carbon::parse($month)->format('F Y') }}</title>

    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
            background: #ffffff;
            color: #091a2a;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #091a2a;
        }

        .header h2 {
            margin: 4px 0;
            font-size: 15px;
            font-weight: normal;
            color: #009d57;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
            color: #64748b;
        }

        .divider {
            height: 3px;
            background: #009d57;
            margin: 15px 0 20px;
            border-radius: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #091a2a;
            color: #ffffff;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th, td {
            padding: 10px;
        }

        td {
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        td.amount {
            text-align: center;
            font-weight: 600;
            color: #091a2a;
        }

        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 20px 0;
        }

        .summary {
            margin-top: 20px;
            padding: 14px;
            border-left: 5px solid #009d57;
            background: #f8fafc;
            font-size: 12px;
        }

        .summary span {
            display: inline-block;
            margin-right: 20px;
        }

        .footer {
            margin-top: 35px;
            font-size: 10px;
            text-align: right;
            color: #94a3b8;
        }

        @media print {
            body { margin: 20px; }
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>StockFlow Inventory System</h1>
        <h2>Sales Report</h2>
        <p>{{ \Illuminate\Support\Carbon::parse($month)->format('F Y') }}</p>
        <p>Generated on {{ now()->format('M d, Y H:i') }}</p>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Qty</th>
                <th class="amount">Total (PHP)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $sale)
                <tr>
                    <td>{{ optional($sale->sale_date)->format('M d, Y H:i') ?? 'N/A' }}</td>
                    <td>{{ $sale->product->name ?? 'N/A' }}</td>
                    <td>{{ $sale->quantity ?? 'N/A' }}</td>
                    <td class="amount">₱{{ number_format($sale->total_amount ?? 0, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="empty">No sales found for this month.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <span><strong>Transactions:</strong> {{ $data->count() }}</span>
        <span><strong>Items Sold:</strong> {{ $data->sum('quantity') }}</span>
        <span><strong>Total Revenue:</strong> ₱{{ number_format($data->sum('total_amount'), 2) }}</span>
    </div>

    <div class="footer">
        StockFlow Inventory System • Generated Report
    </div>

</body>
</html>