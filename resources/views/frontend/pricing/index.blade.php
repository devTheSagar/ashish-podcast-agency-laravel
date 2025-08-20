@extends('frontend.master')

@section('title')
    Pricing
@endsection

@section('content')

<section class="section-padding">
  <div class="container">

    @foreach ($services as $service)
      {{-- Section header --}}
      <div class="section-title text-center">
        <span class="title" data-aos="fade-up" data-aos-duration="600" style="margin-top: 5vh">pricing</span>
        <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">
          {{ $service->serviceName }} pricing
        </h2>
      </div>

      {{-- Plans Grid --}}
      <div class="grid">
        @forelse ($service->plans as $plan)
          @php
            $features = json_decode($plan->planFeatures, true) ?? [];
          @endphp

          <div class="pricing-item" data-aos="fade-up" data-aos-duration="1000">
            <div class="pricing-header">
              <h3>{{ $plan->planName ?? 'Basic' }}</h3>

              {{-- circle price matches your CSS (.pricing-header .price) --}}
              <div class="price">
                <span>${{ is_numeric($plan->planPrice) ? number_format($plan->planPrice, 0) : $plan->planPrice }}</span>
                {{ $plan->planDuration }} days
              </div>
            </div>

            <div class="pricing-body">
              <ul>
                @foreach ($features as $feature)
                  <li><i class="fas fa-check"></i> {{ $feature }}</li>
                @endforeach
              </ul>
            </div>

            <div class="pricing-footer">
              <a href="{{ route('user.plan-details', ['id' => $plan->id]) }}" class="btn">More details</a>
            </div>
          </div>
        @empty
          <div class="card" style="grid-column: span 12;">
            <p>No plans available under this service right now.</p>
          </div>
        @endforelse
      </div>

      {{-- View all link --}}
      <div class="center" style="margin-top: 18px;" data-aos="fade-up" data-aos-duration="1000">
        <a href="{{ route('user.service-details', ['id' => $service->id]) }}" class="btn">
          View all {{ $service->serviceName }} plans
        </a>
      </div>

    @endforeach

  </div>
</section>

@endsection
