@extends('frontend.master')

@section('title')
    About Us
@endsection

@section('content')

<section class="section-padding aboutus">
  <div class="container">
    <div class="section-title">
      <span class="title">who we are</span>
      <h2 class="sub-title">About Us</h2>
    </div>

    @forelse ($aboutUs as $item)
      <div class="grid aboutus-grid {{ $loop->even ? 'is-reverse' : '' }}">
        {{-- Text --}}
        <div class="aboutus-content card">
          <div class="rich">
            {!! $item->aboutUsDetails !!}
          </div>
        </div>

        {{-- Image --}}
        <div class="aboutus-media">
          <div class="img-wrap">
            <img src="{{ $item->aboutUsImage }}" alt="About Us" loading="lazy">
          </div>
        </div>
      </div>
    @empty
      <div class="card">
        <p>No content found.</p>
      </div>
    @endforelse
  </div>
</section>

@endsection
