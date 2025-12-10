<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Podcast Growth | @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="{{ asset('') }}frontend/assets/css/fontawesome.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('') }}frontend/assets/css/aos.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('') }}frontend/assets/css/style-switcher.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('') }}frontend/assets/css/style.css" />
  </head>
  <body>

    <!-- preloader start -->
    <div class="preloader js-preloader">
      <div></div>
    </div>
    <!-- preloader end -->

  <!-- page wrapper start -->
  <div class="page-wrapper">

    <!-- header start -->
    <header class="header js-header">
      <div class="container">
        <div class="logo" data-aos="fade-down" data-aos-duration="1000">
          <a href="{{ route('user.dashboard') }}">
            @if (file_exists(public_path('frontend/assets/logo.png')))
              <img src="{{ asset('frontend/assets/logo.png') }}" alt="Podcast Growth Logo" class="site-logo" />
            @else
              Podcast Growth<span>Podcast Promotion Agency</span>
            @endif
          </a>
        </div>
        <button type="button" class="nav-toggler js-nav-toggler" data-aos="fade-down" data-aos-duration="1000">
          <span></span>
        </button>
        <nav class="nav js-nav">
          <ul data-aos="fade-down" data-aos-duration="1000">
            <li><a href="{{ route('user.dashboard') }}">home</a></li>
            {{-- <li><a href="#about">about</a></li> --}}

            <!-- Dropdown for Services -->
            <li class="dropdown">
              <a href="#services">services</a>
              <ul class="dropdown-menu">
                @foreach ($services as $service)
                  <li><a href="{{ route('user.service-details', ['id' => $service->id]) }}">{{ $service->serviceName }}</a></li>
                @endforeach
              </ul>
            </li>


            {{-- <li><a href="#pricing">pricing</a></li> --}}
            {{-- <li><a href="#team">team</a></li> --}}
            <li><a href="{{ route('user.testimonials') }}">testimonials</a></li>
            <li><a href="{{ route('user.message') }}">contact</a></li>
            <!-- <li><a href="#">account</a></li> -->
            <!-- Dropdown for account -->
            <li class="dropdown">
              @auth
                <a href="#services">{{ Auth::user()->name }}</a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('user.account') }}">My Account</a></li>
                  <li><a href="{{ route('user.track-order') }}">Track Order</a></li>
                  <li>
                  <a href="#" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout.user') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
              </li>
                </ul>
              @endauth

              @guest
                <a href="#services">Account</a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('login') }}">Login</a></li>
                  <li><a href="{{ route('signup.user') }}">Sign Up</a></li>
                  <li><a href="{{ route('user.track-order') }}">Track Order</a></li>
                  {{-- <li><a href="my-account.html">My Account</a></li> --}}
                </ul>
              @endguest
              
            </li>
          </ul>
        </nav>

      </div>
    </header>
  <!-- header end -->