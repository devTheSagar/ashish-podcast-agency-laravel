
<style>
  .alert {
    background: #d4edda;
    color: #155724;
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
    text-align: center;
  }
</style>

@extends('frontend.master')

@section('title')
    Password Reset 
@endsection

@section('content')
   
  <section class="section-padding auth auth-login">
    <div class="container">
      <div class="grid auth-grid">

        <!-- Left: info -->
        <div class="auth-aside">
          <div class="auth-card">
            <h2 class="auth-title">Reset Password</h2>
            <p class="auth-text">Enter your email address and we’ll send a reset link.</p>
            <ul class="auth-points">
              <li>Secure account recovery</li>
              <li>Quick reset process</li>
              <li>Get back to your dashboard</li>
            </ul>
          </div>
        </div>

        <!-- Right: form -->
        <div class="auth-main">
          <div class="auth-card">
            <h3 class="auth-subtitle" style="text-align:center; margin-bottom:5vh;">Reset Password</h3>

            {{-- error / flash area (match login page style) --}}
            <div id="message-area">
              @foreach (['success','status','message','error'] as $key)
                @if (session($key))
                  <div class="alert">{{ session($key) }}</div>
                @endif
              @endforeach
              @error('email')
                <div class="alert">{{ $message }}</div>
              @enderror
            </div>

            <form class="auth-form" method="POST" action="{{ route('password.email') }}" novalidate>
              @csrf

              <div class="input-box">
                <label for="reset-email">Email address</label>
                <input
                  type="email"
                  name="email"
                  id="reset-email"
                  class="input-control @error('email') is-invalid @enderror"
                  placeholder="you@example.com"
                  value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
                  required
                >
              </div>

              <button type="submit" class="btn w-100" style="width:100%;">Get Reset Link</button>

              {{-- <p class="auth-alt">Remembered your password?
                <a href="{{ route('login') }}" class="auth-link">Sign in</a>
              </p> --}}
              @if (!Auth::check())
                <p class="auth-alt">
                  Remembered your password?
                  <a href="{{ route('login') }}" class="auth-link">Sign in</a>
                </p>
              @endif

            </form>
          </div>
        </div>

      </div>
    </div>
  </section>

@endsection