@extends('frontend.master')

@section('title')
    User Account
@endsection

@section('content')

<section class="section-padding">
  <div class="container" style="margin-top: 5vh">
    <div class="card">
      @php
        $serviceName  = data_get($order, 'plan.service.serviceName', '—');
        $planName     = data_get($order, 'plan.planName', '—');
        $planPrice    = data_get($order, 'plan.planPrice', 0);
        $planDuration = (int) data_get($order, 'plan.planDuration', 0);

        $statusKey  = strtolower($order->status ?? '');
        $statusText = ucfirst($order->status ?? '—');
        $badgeClass = match($statusKey){
          'pending','processing'   => 'warning',
          'delivered','completed'  => 'success',
          'cancelled','failed'     => 'danger',
          default                  => ''
        };

        $orderDate    = optional($order->created_at)?->timezone('Asia/Dhaka')->format('d M, Y');
        $deliveryDate = optional($order->created_at)
                          ? $order->created_at->copy()->addDays($planDuration)->timezone('Asia/Dhaka')->format('d M, Y')
                          : '—';
      @endphp

      <h3 class="pane-title" style="display:flex; align-items:center; gap:10px;">
        Order Details
        <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
      </h3>

      <div class="table-wrap mt-10">
        <table class="table">
          <tbody>
            <tr>
              <th style="width:240px;">Order Date</th>
              <td>{{ $orderDate }}</td>
            </tr>
            <tr>
              <th>Delivery Date</th>
              <td>{{ $deliveryDate }}</td>
            </tr>
            <tr>
              <th>Status</th>
              <td><span class="badge {{ $badgeClass }}">{{ $statusText }}</span></td>
            </tr>
            <tr>
              <th>Transaction ID</th>
              <td>{{ $order->transactionId ?? '—' }}</td>
            </tr>
            <tr>
              <th>Plan</th>
              <td>{{ $serviceName }} — {{ $planName }} Plan</td>
            </tr>
            <tr>
              <th>Price</th>
              <td>${{ number_format($planPrice, 2) }} for {{ $planDuration }} days</td>
            </tr>
            <tr>
              <th>Link</th>
              <td>
                @if(!empty($order->link))
                  <a href="{{ $order->link }}" class="table-link" target="_blank" rel="noopener">{{ $order->link }}</a>
                @else
                  —
                @endif
              </td>
            </tr>
            <tr>
              <th>Targeted Countries</th>
              <td>{{ $order->country ?: '—' }}</td>
            </tr>
            <tr>
              <th>Additional Text</th>
              <td>{{ $order->additionalText ?: '—' }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mt-10">
        <a href="{{ route('user.track-order') }}" class="btn btn-light">Back to Orders</a>
      </div>
    </div>
  </div>
</section>

@endsection
