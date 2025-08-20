<style>
  .text-danger{
      color: #dc3545;
  }
</style>
@extends('frontend.master')

@section('title')
    Sign Up 
@endsection

@section('content')


  <section class="section-padding auth auth-signup">
  <div class="container">
    <div class="grid auth-grid">

      <!-- Left: Intro / benefits -->
      <div class="auth-aside">
        <div class="auth-card">
          <h2 class="auth-title">Create your account</h2>
          <p class="auth-text">Join to manage orders, track growth, and access client resources.</p>
          <ul class="auth-points">
            <li>Faster checkout for orders</li>
            <li>Access private resources</li>
            <li>Track progress & updates</li>
          </ul>
        </div>
      </div>

      <!-- Right: Signup form -->
      <div class="auth-main">
        <div class="auth-card">
          <h3 class="auth-subtitle" style="text-align: center; margin-bottom: 5vh">Sign up</h3>

          <form class="auth-form" id="signupForm" action="{{ route('register.user') }}" method="POST" novalidate>
            @csrf
            <div class="input-box">
              <label for="su-name">Full name</label>
              <input type="text" id="su-name" name="name" class="input-control @error('name') is-invalid @enderror" placeholder="Your full name" required>
              @error('name')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-box">
              <label for="su-email">Email address</label>
              <input type="email" name="email" id="su-email" class="input-control @error('email') is-invalid @enderror" placeholder="you@example.com" required>
              @error('email')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-box password-box">
              <label for="su-password">Password</label>
              <div class="password-wrap">
                <input type="password" name="password" id="su-password" class="input-control @error('password') is-invalid @enderror" placeholder="At least 6 characters" required minlength="6">
                <button type="button" class="pw-toggle" data-target="su-password" aria-label="Show password">Show</button>
              </div>
              @error('password')
                <div class="text-danger">{{ $message }}</div>
              @enderror
              <div class="pw-strength" id="pwStrength" aria-live="polite">
                <span class="bar"></span><span class="bar"></span><span class="bar"></span><span class="bar"></span>
                <em class="label">Strength: —</em>
              </div>
            </div>

            <div class="input-box password-box">
              <label for="su-confirm">Confirm password</label>
              <div class="password-wrap">
                <input type="password" id="su-confirm" class="input-control" placeholder="Re-type password" required minlength="6">
                <button type="button" class="pw-toggle" data-target="su-confirm" aria-label="Show password">Show</button>
              </div>
              <small class="match-hint" id="matchHint"></small>
            </div>

            <div class="auth-row">
              <label class="remember">
                <input type="checkbox" id="su-terms" required>
                <span>I agree to the <a href="#">terms</a> and <a href="{{ route('user.privacy-policy') }}">privacy policy</a></span>
              </label>
            </div>

            <button type="submit" class="btn" style="width:100%">Create account</button>

            <div class="auth-or"><span>or</span></div>

            <!-- <div class="social-row">
              <button type="button" class="btn btn-light w-100">Sign up with Google</button>
              <button type="button" class="btn btn-light w-100">Sign up with Facebook</button>
            </div> -->

            <p class="auth-alt">Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign in</a></p>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
