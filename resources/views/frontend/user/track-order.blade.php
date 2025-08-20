@extends('frontend.master')

@section('title')
    User Account
@endsection

@section('content')

<section class="section-padding">
  <div class="container" style="margin-top: 5vh">
    <div class="card">
      <h3 class="pane-title">Orders</h3>

      @if($orders->isEmpty())
        <p class="muted">You don’t have any orders yet.</p>
      @else
        <div class="table-wrap mt-10">
          <table class="table">
            <thead>
              <tr>
                <th>SL</th>
                <th>Service</th>
                <th>Plan</th>
                <th>Price</th>
                <th>Purchase Date</th>
                <th>Delivery Date</th>
                <th>Status</th>
                <th style="width: 110px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($orders as $order)
                @php
                  $serviceName = data_get($order, 'plan.service.serviceName', '—');
                  $planName    = data_get($order, 'plan.planName', '—');
                  $planPrice   = data_get($order, 'plan.planPrice', 0);
                  $statusText  = ucfirst($order->status ?? '—');
                  $statusKey   = strtolower($order->status ?? '');
                  $badgeClass  = match($statusKey){
                    'pending','processing' => 'warning',
                    'delivered','completed' => 'success',
                    'cancelled','failed' => 'danger',
                    default => ''
                  };
                @endphp

                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $serviceName }}</td>
                  <td>{{ $planName }}</td>
                  <td>${{ number_format($planPrice, 2) }}</td>
                  <td>{{ optional($order->created_at)->timezone('Asia/Dhaka')->format('d M, Y') }}</td>
                  <td>
                    {{ optional($order->created_at)
                        ? $order->created_at->copy()->addDays((int) data_get($order,'plan.planDuration',0))->timezone('Asia/Dhaka')->format('d M, Y')
                        : '—' }}
                  </td>
                  <td>
                    <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                  </td>
                  <td>
                    <a href="{{ route('user.order-details', ['id' => $order->id]) }}" class="table-link">View</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</section>

@endsection
