@extends('frontend.master')

@section('title')
    Service Details
@endsection

@section('content')

  <section class="pricing section-padding" id="pricing">
    <div class="container">
      <div class="section-title">
        <span class="title" data-aos="fade-up" data-aos-duration="600">Service Details</span>
        <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">Service Details</h2>
      </div>
      <div data-aos="fade-up" data-aos-duration="600">
        <p data-aos="fade-up" data-aos-duration="600">{!! ucfirst($service->serviceDetails) !!}</p>
      </div>
      <div class="section-title">
        <span class="title" data-aos="fade-up" data-aos-duration="600">pricing</span>
        <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">our pricing plans</h2>
      </div>
      <div class="grid">
        <!-- basic plan start -->
        @foreach ($service->plans as $plan)
          <div class="pricing-item" data-aos="fade-up" data-aos-duration="1000">
            <div class="pricing-header">
              <h3>{{ $plan->planName }}</h3>
              <div class="price"><span>${{ $plan->planPrice }}</span> {{$plan->planDuration}} Days</div>
            </div>
            <div class="pricing-body">
              <ul>
                @foreach (json_decode($plan->planFeatures, true) as $feature)
                  <li><i class="fas fa-check"></i> {{ $feature }}</li>
                @endforeach
              </ul>
            </div>
            <div class="pricing-footer">
              @if (Str::contains(strtolower($plan->planName), 'custom'))
                <a href="{{ route('user.message') }}" class="btn">Contact Us</a>
              @else
                <a href="{{ route('user.plan-details', ['id' => $plan->id]) }}" class="btn">More Details</a>
              @endif
              {{-- <a href="#" class="btn">get started</a> --}}
            </div>
          </div>
        @endforeach
        <!-- basic plan end -->
      </div>
      <div style="margin-top: 50px" data-aos="fade-up" data-aos-duration="600">
        <p  data-aos="fade-up" data-aos-duration="600">Looking for a custom plan tailored specifically to your unique needs? We’re here to help! Please reach out to us with your requirements and any specific details you have in mind. Our team will work closely with you to design a personalized plan that fits your goals perfectly. Don’t hesitate to <a href="{{ route('user.send-message') }}">contact us</a> — let’s create the ideal solution together!</p>
      </div>
    </div>
  </section>

@endsection