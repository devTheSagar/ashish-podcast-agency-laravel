<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; position: relative; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        h1, h2, h3 { margin-bottom: 0; }
        .header { margin-bottom: 40px; }

        /* Watermark styles */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(0, 0, 0, 0.1);
            user-select: none;
            pointer-events: none;
            z-index: 0;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="watermark">podcastranker.net</div>

    <div class="header">
        <h1>Invoice #{{ $order->id }}</h1>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    <h2>Client Details</h2>
    <table>
        <tr><th>Name</th><td>{{ $order->name }}</td></tr>
        <tr><th>Email</th><td>{{ $order->email }}</td></tr>
        <tr><th>Phone</th><td>{{ $order->phone }}</td></tr>
    </table>

    <h2>Order Details</h2>
    <table>
        <tr><th>Transaction ID</th><td>{{ $order->transactionId }}</td></tr>
        {{-- <tr><th>Additional Info</th><td>{{ $order->additionalText }}</td></tr> --}}
        <tr><th>Link</th><td><a href="{{ $order->link }}" target="_blank">{{ $order->link }}</a></td></tr>
        <tr><th>Targeted Country</th><td>{{ $order->country }}</td></tr>
    </table>

    <h2>Service Details</h2>
    <table>
        <tr><th>Plan Name</th><td>{{ $order->plan->service->serviceName ?? 'N/A' }} {{ $order->plan->planName ?? 'N/A' }} Plan</td></tr>
        <tr><th>Price</th><td>${{ number_format($order->plan->planPrice ?? 0, 2) }}</td></tr>
        <tr><th>Duration (days)</th><td>{{ $order->plan->planDuration ?? 'N/A' }}</td></tr>
        <tr>
            <th>Features</th>
            <td>
                @php
                    // Decode if JSON string, or fallback to empty array
                    $features = is_array($order->plan->planFeatures)
                        ? $order->plan->planFeatures
                        : json_decode($order->plan->planFeatures, true) ?? [];
                @endphp
                @if(count($features))
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @else
                    N/A
                @endif
            </td>
        </tr>
    </table>

    <hr>
    <h2>Total Amount: ${{ number_format($order->plan->planPrice ?? 0, 2) }}</h2>
</body>
</html>
