@extends('frontend.master')

@section('title')
    Contact 
@endsection

@section('content')
 
<section class="contact section-padding" id="contact">
    <div class="container">
      <div class="section-title">
        <span class="title" data-aos="fade-up" data-aos-duration="600">contact us</span>
        <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">have any question ?</h2>
      </div>
      <div class="grid contact-grid">
        <div class="contact-info">
          <div class="contact-info-item" data-aos="fade-up" data-aos-duration="600">
            <i class="fas fa-phone"></i>
            <h3>Call us</h3>
            @if ($contactInfo && $contactInfo->phone)
              <p>{!! $contactInfo->phone !!}</p>
            @else
              <p>No phone found.</p>
            @endif
          </div>
          <div class="contact-info-item" data-aos="fade-up" data-aos-duration="600">
            <i class="fas fa-envelope"></i>
            <h3>Email us</h3>
            @if ($contactInfo && $contactInfo->email)
              <p>{!! $contactInfo->email !!}</p>
            @else
              <p>No email found.</p>
            @endif
          </div>
          <div class="contact-info-item" data-aos="fade-up" data-aos-duration="600">
            <i class="fas fa-map-marker-alt"></i>
            <h3>Address</h3>
            @if ($contactInfo && $contactInfo->addressDetails)
              <p>{!! $contactInfo->addressDetails !!}</p>
            @else
              <p>No address found.</p>
            @endif
          </div>
        </div>
        <div class="contact-form" data-aos="fade-up" data-aos-duration="600">
          <form action="{{ route('user.send-message') }}" method="POST">
            @csrf
            <div class="input-box">
              <input type="text" placeholder="Name" name="senderName" class="input-control @error('senderName') is-invalid @enderror" value="{{ old('senderName', Auth::check() ? Auth::user()->name : '') }}">
              @error('senderName')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="input-box">
              <input type="text" placeholder="Email" name="senderEmail" class="input-control @error('senderEmail') is-invalid @enderror" value="{{ old('senderEmail', Auth::check() ? Auth::user()->email : '') }}">
              @error('senderEmail')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="input-box">
              <input type="number" placeholder="Phone" name="senderPhone" class="input-control @error('senderPhone') is-invalid @enderror">
              @error('senderPhone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="input-box">
              <textarea placeholder="Message" name="senderMessage" class="input-control @error('senderMessage') is-invalid @enderror"></textarea>
              @error('senderMessage')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <button type="submit" class="btn">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </section>

@endsection