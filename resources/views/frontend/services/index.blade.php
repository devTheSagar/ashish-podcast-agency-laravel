@extends('frontend.master')

@section('title')
    Service Details
@endsection

@section('content')
    <!-- breadcrumb start -->
  <div class="breadcrumb-nav">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">service</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- breadcrumb end -->

  <!-- pricing section start -->
  <section class="service-pricing" id="pricing">
    <div class="container">
      <div class="section-title text-center m-0 p-0">
        <span class="title" data-aos="fade-up" data-aos-duration="600">Service Details</span>
        <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">Service Details</h2>
      </div>
      <div>
        <p>{!! ucfirst($service->serviceDetails) !!}</p>
      </div>
      <div class="section-title text-center">
        <span class="title" data-aos="fade-up" data-aos-duration="600">pricing</span>
        <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">{{ ucwords($service->serviceName) }} pricing plans</h2>
      </div>
      <div class="grid mb-5">
        @foreach ($service->plans as $plan)
          <div class="pricing-item" data-aos="fade-up" data-aos-duration="1000">
            <div class="pricing-header">
              <h3>{{ $plan->planName }}</h3>
              <div class="service-price"><span>$ {{ $plan->planPrice }}</span> {{$plan->planDuration}} days</div>
            </div>
            <div class="pricing-body">
              <ul>
                @foreach (json_decode($plan->planFeatures, true) as $feature)
                  <li><i class="fas fa-check"></i> {{ $feature }}</li>
                @endforeach
              </ul>
            </div>
            <div class="pricing-footer">
              {{-- <a href="{{ route('user.plan-details', ['id' => $plan->id]) }}" class="btn">more deatils</a> --}}
              @if (Str::contains(strtolower($plan->planName), 'custom'))
                <a href="{{ route('user.message') }}" class="btn">Contact Us</a>
              @else
                <a href="{{ route('user.plan-details', ['id' => $plan->id]) }}" class="btn">More Details</a>
              @endif
            </div>
          </div>
        @endforeach
      </div>
      <div class="mb-5">
        <p>Looking for a custom plan tailored specifically to your unique needs? We’re here to help! Please reach out to us with your requirements and any specific details you have in mind. Our team will work closely with you to design a personalized plan that fits your goals perfectly. Don’t hesitate to <a href="{{ route('user.send-message') }}">contact us</a> — let’s create the ideal solution together!</p>
      </div>
    </div>
  </section>
  <!-- pricing section end -->
@endsection