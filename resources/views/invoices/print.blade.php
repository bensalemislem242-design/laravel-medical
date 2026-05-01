<!DOCTYPE html>
<html>
<head>
    <title>Invoice Print</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 40px;
        }
        .invoice-box {
            border: 1px solid #ddd;
            padding: 20px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <h2 class="mb-4">Invoice</h2>

    <p><strong>Title:</strong> {{ $invoice->title }}</p>
    <p><strong>Patient:</strong> {{ $invoice->patient?->name ?? '-' }}</p>
    <p><strong>Amount:</strong> {{ $invoice->amount }} TND</p>
    <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
    <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>

    <br>

    <button onclick="window.print()" class="btn btn-success no-print">
        Print Now
    </button>
</div>

</body>
</html>
