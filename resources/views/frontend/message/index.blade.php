@extends('frontend.master')

@section('title')
    Contact 
@endsection

@section('content')
    <!-- breadcrumb start -->
  <div class="breadcrumb-nav">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">contact</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- breadcrumb end -->

  <!-- contact section start -->
  <section class="contact-section section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="section-title">
            <p class="sub-title">Get In Touch</p>
          </div>
          <div class="contact-items">
            <div class="contact-item">
              <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
              <h3>Address</h3>
              @if ($contactInfo && $contactInfo->addressDetails)
                  <p>{!! $contactInfo->addressDetails !!}</p>
              @else
                  <p>No address found.</p>
              @endif
            </div>
            <div class="contact-item">
              <div class="icon-box"><i class="fas fa-phone"></i></div>
              <h3>Phone</h3>
              @if ($contactInfo && $contactInfo->phone)
                  <p>{!! $contactInfo->phone !!}</p>
              @else
                  <p>No phone found.</p>
              @endif
            </div>
            <div class="contact-item">
              <div class="icon-box"><i class="fas fa-envelope"></i></div>
              <h3>Email</h3>
              @if ($contactInfo && $contactInfo->email)
                  <p>{!! $contactInfo->email !!}</p>
              @else
                  <p>No email found.</p>
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="contact-form box">
            <h2 class="form-title text-center">Leave a Message</h2>
            <form action="{{ route('user.send-message') }}" method="POST">
              @csrf
              <div class="form-group">
                <input name="senderName" type="text" class="form-control @error('senderName') is-invalid @enderror" placeholder="Name" value="{{ old('senderName', Auth::check() ? Auth::user()->name : '') }}">
                @error('senderName')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <input name="senderEmail" type="email" class="form-control @error('senderEmail') is-invalid @enderror" placeholder="Email" value="{{ old('senderEmail', Auth::check() ? Auth::user()->email : '') }}">
                @error('senderEmail')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <input name="senderPhone" type="number" class="form-control @error('senderPhone') is-invalid @enderror" placeholder="Phone">
                @error('senderPhone')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <textarea name="senderMessage" class="form-control @error('senderMessage') is-invalid @enderror" placeholder="Message"></textarea>
                @error('senderMessage')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <button type="submit" class="btn btn-block btn-theme btn-form">send message</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- contact section end -->

@endsection