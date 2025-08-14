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
                    <tbody>
                        <tr>
                            <td>Odrder Date</td>
                            <td>{{ $order->created_at->timezone('Asia/Dhaka')->format('d M, Y') }}</td>
                        </tr>
                        <tr>
                            <td>Delivery Date</td>
                            <td>{{ $order->created_at->copy()->addDays($order->plan->planDuration)->timezone('Asia/Dhaka')->format('d M, Y ') }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{{ $order->status }}</td>
                        </tr>
                        <tr>
                            <td>Transaction Id</td>
                            <td>{{ $order->transactionId }}</td>
                        </tr>
                        <tr>
                            <td>Plan</td>
                            <td>{{ $order->plan->service->serviceName }} {{ $order->plan->planName }} Plan</td>
                        </tr>
                        <tr>
                            <td>Link</td>
                            <td><a href="{{ $order->link }}" target="_blank">{{ $order->link }}</a></td>
                        </tr>
                        <tr>
                            <td>Targated Countries</td>
                            <td>{{ $order->country }}</td>
                        </tr>
                        <tr>
                            <td>Additional Text</td>
                            <td>{{ $order->additionalText }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
  <!-- content end  -->
@endsection