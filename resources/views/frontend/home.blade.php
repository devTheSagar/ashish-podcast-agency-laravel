@extends('frontend.master')

@section('title')
  Home
@endsection

@section('content')
    
  <!-- home section start -->
  <section class="home" id="home">
    <div class="container">
      <div class="grid">
        <div class="home-text">
          <h1 data-aos="fade-up" data-aos-duration="1000">Grow Your Podcast Downloads & Rankings Fast</h1>
          <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">Grow your podcast with real listeners, chart rankings, and consistent weekly downloads — powered by our proven Apple & Spotify growth system.</p>
          <div class="btn-wrap" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
            <a href="{{ route('user.message') }}" class="btn">Start Free Trial</a>
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
            <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">Trusted Podcast Growth Experts Since 2015</h2>
          </div>
          <p data-aos="fade-up" data-aos-duration="600">We help podcasters grow their audience, boost downloads, and achieve top chart rankings through proven, data-driven marketing strategies. Our goal is simply  connect your podcast with the right listeners and deliver measurable, long-term growth.</p>
          <p data-aos="fade-up" data-aos-duration="600">With years of experience in podcast promotion, we specialize in increasing visibility, improving listener engagement, and unlocking monetization opportunities. Let us take your show to the next level while you focus on creating great content.</p>
          <p data-aos="fade-up" data-aos-duration="600">Our team combines podcast SEO, category and keyword research, listener behavior analysis, and platform-specific promotion to give your show an unfair advantage. Whether you are launching a new podcast or trying to revive a stalled show, we build a growth plan tailored to your niche, audience, and goals.</p>
          <p data-aos="fade-up" data-aos-duration="600">From Apple Podcasts and Spotify to social media and cross-promotion, we make sure your podcast is discovered in the right places by the right people. Every campaign is tracked, optimized, and refined using real performance data  so you always know what’s working and where your growth is coming from.</p>
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
            <h3>Rhea</h3>
            <p>Team Lead</p>
          </div>
        </div>
        <!-- team item end -->
        <!-- team item start -->
        <div class="team-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
          <div class="img-box">
            <img src="{{ asset('') }}frontend/assets/img/team/2.png" alt="img">
          </div>
          <div class="detail">
            <h3>Arnav</h3>
            <p>Team Lead</p>
          </div>
        </div>
        <!-- team item end -->
        <!-- team item start -->
        <div class="team-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
          <div class="img-box">
            <img src="{{ asset('') }}frontend/assets/img/team/4.png" alt="img">
          </div>
          <div class="detail">
            <h3>Siya</h3>
            <p>Team Lead</p>
          </div>
        </div>
        <!-- team item end -->
      </div>
    </div>
  </section>
  <!-- team section end -->

@endsection