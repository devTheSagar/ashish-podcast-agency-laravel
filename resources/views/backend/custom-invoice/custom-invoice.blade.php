<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        /* define the vars you used OR just use hex in .note (see next block) */
        :root{
        --line: #e5e7eb;
        --muted: #6b7280;
        }

        /* avoid float issues by not floating the totals table */
        .totals-table{
        width: 250px;
        margin: 10px 0 0 auto;  /* pushes it to the right */
        border: none;
        float: none;            /* <-- was float:right */
        }

        /* make the note show and sit below totals */
        .note{
        text-align: center;
        clear: both;            /* ensures it appears under totals */
        margin-top: 16px;
        padding-top: 8px;
        border-top: 1px dashed var(--line); /* or #e5e7eb */
        color: var(--muted);                 /* or #6b7280 */
        font-size: 10px;
        }

        /* OPTIONAL: keep the note pinned at the bottom of printed page */
        @media print{
            .note{
                text-align: center;
                margin-top: 10px;
                position: fixed;
                bottom: 10mm;
                left: 14mm;
                right: 14mm;
                background: #fff;
            }
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
            background-color: #fff;
            color: #333;
            font-size: 12px; /* Reduced font size */
        }
        h1, h2 {
            margin: 0 0 8px;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 1px solid #0073aa;
            padding-bottom: 5px;
        }
        .header h1 {
            color: #0073aa;
            font-size: 18px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 15px;
            background: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #f1f1f1;
        }
        .section-title {
            margin-top: 15px;
            color: #0073aa;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
            font-size: 14px;
        }
        /* Totals Section */
        .totals-table {
            width: 250px;
            float: right;
            margin-top: 10px;
            border: none;
        }
        .totals-table th, .totals-table td {
            border: none;
            padding: 4px 6px;
            font-size: 13px;
        }
        .totals-table td {
            text-align: right;
        }
        .grand-total {
            font-size: 14px;
            font-weight: bold;
            color: #0073aa;
            border-top: 1px solid #0073aa;
            padding-top: 4px;
        }
        /* Watermark - reduced size */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 40px;
            color: rgba(0, 0, 0, 0.04);
            user-select: none;
            pointer-events: none;
            z-index: 0;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div>
        <div class="watermark">podcastgrowth.agency</div>

    <div class="header">
        <h1>PodcastPromotion.online</h1>
        <p>Invoice #{{ $invoice->id }}</p>
        <p><strong>Order Date:</strong> {{ $invoice->created_at->format('d M Y') }}</p>
    </div>

    <h2 class="section-title">Client Details</h2>
    <table>
        <tr><th>Name</th><td>{{ $invoice->clientName }}</td></tr>
        <tr><th>Email</th><td>{{ $invoice->clientEmail }}</td></tr>
        <tr><th>Phone</th><td>{{ $invoice->clientPhone }}</td></tr>
    </table>

    <h2 class="section-title">Order Details</h2>
    <table>
        <tr><th>Plan Name</th><td>{{ $invoice->serviceName }}</td></tr>
        <tr><th>Price</th><td>${{ number_format($invoice->price ?? 0, 2) }}</td></tr>
        <tr><th>Duration</th><td>{{ $invoice->duration ?? 'N/A' }}</td></tr>
        <tr><th>Features</th><td>{{ $invoice->features }}</td></tr>
        <tr><th>Link</th><td><a href="{{ $invoice->link }}" target="_blank">{{ $invoice->link }}</a></td></tr>
        <tr><th>Country</th><td>{{ $invoice->country }}</td></tr>
    </table>

    <h2 class="section-title">Payment Details</h2>
    <table>
        <tr><th>Payment Method</th><td>{{ $invoice->paymentMethod }}</td></tr>
        <tr><th>Transaction Id</th><td>{{ $invoice->transactionId }}</td></tr>
    </table>

    <table class="totals-table">
        <tr><th>Amount Paid:</th><td>${{ number_format($invoice->amountPaid, 2) }}</td></tr>
        <tr><th>Tips:</th><td>${{ number_format($invoice->tips, 2) }}</td></tr>
        <tr><th>Payment Due:</th><td>${{ number_format(($invoice->price + $invoice->tips - $invoice->amountPaid), 2) }}</td></tr>
        <tr><th class="grand-total">Total Amount:</th><td class="grand-total">${{ number_format(($invoice->price + $invoice->tips), 2) }}</td></tr>
    </table>
    </div>
    <p class="note"> This is a system-generated invoice from PodcastPromotion.online. If you have any questions, please contact support.</p>
</body>
</html>
