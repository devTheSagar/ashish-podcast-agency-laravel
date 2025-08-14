@extends('frontend.master')

@section('title')
    User Account
@endsection

@section('content')
    <!-- breadcrumb start -->
  <div class="breadcrumb-nav">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Track Order</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- breadcrumb end -->

  <!-- content start  -->
  <div class="container mb-5">
    <div class="row mt-5">
        <div class="col-lg-12">
            <h5>Orders</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Service</th>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>purchace date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->plan->service->serviceName }}</td>
                                <td>{{ $order->plan->planName }}</td>
                                <td>${{ $order->plan->planPrice }}</td>
                                <td>{{ $order->created_at->timezone('Asia/Dhaka')->format('d M, Y') }}</td>
                                <td>{{ $order->created_at->copy()->addDays($order->plan->planDuration)->timezone('Asia/Dhaka')->format('d M, Y ') }}</td>
                                <td>{{ $order->status }}</td>
                                <td>
                                    <a href="{{ route('user.order-details', ['id' => $order->id]) }}" type="submit">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
  <!-- content end  -->
@endsection