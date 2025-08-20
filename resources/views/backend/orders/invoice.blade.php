<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Invoice #{{ $order->id }}</title>
  <style>
    :root{
      --line: #e5e7eb;
      --muted: #6b7280;
    }

    body{
      font-family: Arial, sans-serif;
      line-height: 1.4;
      margin: 0;
      padding: 15px;
      background-color: #fff;
      color: #333;
      font-size: 12px; /* reduced font size */
    }

    h1, h2{ margin: 0 0 8px; }

    .header{
      margin-bottom: 20px;
      border-bottom: 1px solid #0073aa;
      padding-bottom: 5px;
    }
    .header h1{
      color: #0073aa;
      font-size: 18px;
    }

    table{
      border-collapse: collapse;
      width: 100%;
      margin-bottom: 15px;
      background: #fff;
    }
    th, td{
      border: 1px solid #ddd;
      padding: 6px;
      text-align: left;
      vertical-align: top;
    }
    th{ background: #f1f1f1; }

    .section-title{
      margin-top: 15px;
      color: #0073aa;
      border-bottom: 1px solid #ddd;
      padding-bottom: 3px;
      font-size: 14px;
    }

    /* Totals: push the box to the right without floats */
    .totals-table{
      width: 250px;
      margin: 10px 0 0 auto; /* right aligned block */
      border: none;
    }
    .totals-table th, .totals-table td{
      border: none;
      padding: 4px 6px;
      font-size: 13px;
    }
    .totals-table td{ text-align: right; }
    .grand-total{
      font-size: 14px;
      font-weight: bold;
      color: #0073aa;
      border-top: 1px solid #0073aa;
      padding-top: 4px;
    }

    /* Watermark */
    .watermark{
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-45deg);
      font-size: 40px;
      color: rgba(0,0,0,0.04);
      user-select: none;
      pointer-events: none;
      z-index: 0;
      white-space: nowrap;
    }

    /* Footer note */
    .note{
      text-align: center;
      clear: both;
      margin-top: 16px;
      padding-top: 8px;
      border-top: 1px dashed var(--line);
      color: var(--muted);
      font-size: 10px;
    }

    /* Optional: keep note near bottom when printing */
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
  </style>
</head>
<body>
  <div class="watermark">PodcastPromotion.online</div>

  <div class="header">
    <h1>Invoice #{{ $order->id }}</h1>
    <p>PodcastPromotion.online</p>
    <p><strong>Order Date:</strong> {{ optional($order->created_at)->format('d M Y') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status ?? '—') }}</p>
  </div>

  <h2 class="section-title">Client Details</h2>
  <table>
    <tr><th>Name</th><td>{{ $order->name }}</td></tr>
    <tr><th>Email</th><td>{{ $order->email }}</td></tr>
    <tr><th>Phone</th><td>{{ $order->phone }}</td></tr>
  </table>

  <h2 class="section-title">Order Details</h2>
  <table>
    <tr><th>Transaction ID</th><td>{{ $order->transactionId }}</td></tr>
    {{-- <tr><th>Additional Info</th><td>{{ $order->additionalText }}</td></tr> --}}
    <tr>
      <th>Link</th>
      <td>
        @if(!empty($order->link))
          <a href="{{ $order->link }}" target="_blank" rel="noopener">{{ $order->link }}</a>
        @else
          N/A
        @endif
      </td>
    </tr>
    <tr><th>Targeted Country</th><td>{{ $order->country }}</td></tr>
  </table>

  <h2 class="section-title">Service Details</h2>
  <table>
    <tr>
      <th>Plan Name</th>
      <td>{{ data_get($order,'plan.service.serviceName','N/A') }} {{ data_get($order,'plan.planName','N/A') }} Plan</td>
    </tr>
    <tr>
      <th>Price</th>
      <td>${{ number_format((float) data_get($order,'plan.planPrice',0), 2) }}</td>
    </tr>
    <tr>
      <th>Duration (days)</th>
      <td>{{ data_get($order,'plan.planDuration') ?? 'N/A' }}</td>
    </tr>
    <tr>
      <th>Features</th>
      <td>
        @php
          $raw = data_get($order,'plan.planFeatures');
          $features = is_array($raw) ? $raw : (json_decode((string)$raw, true) ?? []);
        @endphp
        @if(count($features))
          <ul style="margin:0; padding-left:18px;">
            @foreach($features as $feature)
              <li>{{ $feature }}</li>
            @endforeach
          </ul>
        @else
          N/A
        @endif
      </td>
    </tr>
  </table>

  <table class="totals-table">
    <tr><th>Amount Paid:</th><td>${{ number_format((float) data_get($order,'plan.planPrice',0), 2) }}</td></tr>
    <tr><th>Payment Due:</th><td>$0</td></tr>
    <tr><th class="grand-total">Total Amount:</th><td class="grand-total">${{ number_format((float) data_get($order,'plan.planPrice',0), 2) }}</td></tr>
  </table>

  <p class="note">This is a system-generated invoice from PodcastPromotion.online. If you have any questions, please contact support.</p>
</body>
</html>
