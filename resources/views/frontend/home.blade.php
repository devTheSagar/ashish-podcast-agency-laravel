@extends('frontend.master')

@section('title')
  Podcast Promotion
@endsection

@section('content')
    
  <!-- home section start -->
  <section class="home" id="home">
    <div class="container">
      <div class="grid">
        <div class="home-text">
          <h1 data-aos="fade-up" data-aos-duration="1000">need cleaning services ? </h1>
          <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis eligendi dolore ipsa corporis, provident facere.</p>
          <div class="btn-wrap" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
            <a href="#about" class="btn">know more</a>
          </div>
        </div>
        <div class="home-img">
          <div class="circle-wrap" data-aos="fade-right" data-aos-duration="1000">
            <div class="circle"></div>
          </div>
          <img src="{{ asset('') }}frontend/assets/img/home-img.png" alt="img" data-aos="fade-left" data-aos-duration="1000">
        </div>
      </div>
    </div>
  </section>
  <!-- home section end -->

  <!-- about section start -->
  <section class="about section-padding" id="about">
    <div class="container">
      <div class="grid">
        <div class="about-img">
          <div class="img-box" data-aos="zoom-in" data-aos-duration="1000">
            <img src="{{ asset('') }}frontend/assets/img/about-img.png" alt="img">
            <div class="box box-1">
              <span>2.5k</span>
              <p>satisfied clients</p>
            </div>
          </div>
        </div>
        <div class="about-text">
          <div class="section-title">
            <span class="title" data-aos="fade-up" data-aos-duration="600">about us</span>
            <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">we're cleaning since 2010</h2>
          </div>
          <p data-aos="fade-up" data-aos-duration="600">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit non eius a assumenda! Nostrum exercitationem commodi itaque sed ullam totam!</p>
          <p data-aos="fade-up" data-aos-duration="600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem cumque accusantium commodi laudantium sapiente beatae, praesentium perspiciatis ex aperiam sunt?</p>
        </div>
      </div>
    </div>
  </section>
  <!-- about section end -->

  <!-- services section start -->
  <section class="services section-padding" id="services">
    <div class="container">
      <div class="section-title">
        <span class="title" data-aos="fade-up" data-aos-duration="600">services</span>
        <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">what we do</h2>
      </div>
      <div class="grid">
        <!-- services item start -->
        @foreach ($services as $service)
          <a href="{{ route('user.service-details', ['id' => $service->id]) }}" class="services-item" data-aos="fade-up" data-aos-duration="600">
            <div class="img-box">
                <img src="{{ asset($service->serviceImage) }}" alt="Service Image">
            </div>
            <h3>{{ $service->serviceName }}</h3>
          </a>
        @endforeach
      </div>
    </div>
  </section>
  <!-- services section end -->

  <!-- pricing section start -->
  <section class="pricing section-padding" id="pricing">
    <div class="container">
      @foreach ($services as $service)
        <div class="section-title">
          <span class="title" data-aos="fade-up" data-aos-duration="600">pricing</span>
          <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">{{ ucwords($service->serviceName) }} pricing plans</h2>
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
                {{-- <a href="service-details.html" class="btn">get started</a> --}}
              </div>
            </div>
          @endforeach
          <!-- basic plan end -->
        </div>
        <div class="row">
          <div style="margin-top: 30px; text-align:center" data-aos="fade-up" data-aos-duration="600">
            <a href="{{ route('user.service-details', ['id' => $service->id]) }}" class="btn btn-theme">view all {{ $service->serviceName }} plans</a>
          </div>
        </div>
      @endforeach
    </div>
  </section>
  <!-- pricing section end -->

  <!-- team section start -->
  <section class="team section-padding" id="team">
    <div class="container">
      <div class="section-title">
        <span class="title" data-aos="fade-up" data-aos-duration="600">team</span>
        <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">meet our team</h2>
      </div>
      <div class="grid">
        <!-- team item start -->
        <div class="team-item" data-aos="fade-up" data-aos-duration="1000">
          <div class="img-box">
            <img src="{{ asset('') }}frontend/assets/img/team/1.png" alt="img">
          </div>
          <div class="detail">
            <h3>john doe</h3>
            <p>team leader</p>
          </div>
        </div>
        <!-- team item end -->
        <!-- team item start -->
        <div class="team-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
          <div class="img-box">
            <img src="{{ asset('') }}frontend/assets/img/team/2.png" alt="img">
          </div>
          <div class="detail">
            <h3>john doe</h3>
            <p>car cleaner</p>
          </div>
        </div>
        <!-- team item end -->
        <!-- team item start -->
        <div class="team-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
          <div class="img-box">
            <img src="{{ asset('') }}frontend/assets/img/team/3.png" alt="img">
          </div>
          <div class="detail">
            <h3>john doe</h3>
            <p>cleaner</p>
          </div>
        </div>
        <!-- team item end -->
      </div>
    </div>
  </section>
  <!-- team section end -->

@endsection