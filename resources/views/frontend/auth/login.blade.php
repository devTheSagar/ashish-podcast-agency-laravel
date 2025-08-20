
<style>
  .alert {
      background: #f5ccd0;
      color: #dc3545;
      padding: 10px 15px;
      border-radius: 6px;
      margin-bottom: 20px;
      border: 1px solid #c3e6cb;
      text-align: center;
  }
  .text-danger{
      color: #dc3545;
  }
</style>


@extends('frontend.master')

@section('title')
    Login 
@endsection

@section('content')

  <section class="section-padding auth auth-login">
  <div class="container">
    <div class="grid auth-grid">

      <!-- Left: Welcome / copy -->
      <div class="auth-aside">
        <div class="auth-card">
          <h2 class="auth-title">Welcome back</h2>
          <p class="auth-text">Log in to manage your podcast promotions, track orders, and access your dashboard.</p>
          <ul class="auth-points">
            <li>View current plans & orders</li>
            <li>Faster checkout next time</li>
            <li>Access client resources</li>
          </ul>
        </div>
      </div>

      <!-- Right: Form -->
      <div class="auth-main">
        <div class="auth-card">
          <h3 class="auth-subtitle" style="text-align: center; margin-bottom: 5vh">Login</h3>
          <div id="message-area">
            @foreach (['status','success','message','error'] as $key)
              @if (session($key))
                <div class="alert text-center">{{ session($key) }}</div>
              @endif
            @endforeach
            @if ($errors->has('loginError'))
              <div class="alert">{{ $errors->first('loginError') }}</div>
            @endif
          </div>

          <form class="auth-form" action="{{ route('login') }}" method="POST" novalidate>
            @csrf
            <div class="input-box">
              <label for="email">Email address</label>
              <input type="email" name="email" id="email" class="input-control @error('email') is-invalid @enderror" placeholder="you@example.com" required>
              @error('email')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-box password-box">
              <label for="password">Password</label>
              <div class="password-wrap">
                <input type="password" name="password" id="password" class="input-control @error('password') is-invalid @enderror" placeholder="••••••••" required minlength="6">
                <button type="button" class="pw-toggle" aria-label="Show password">Show</button>
              </div>
              @error('password')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="auth-row">
              <label class="remember">
                <input type="checkbox" id="remember">
                <span>Remember me</span>
              </label>
              <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn" style="width:100%">Sign in</button>
            
            <div class="auth-or"><span>or</span></div>

            <!-- <div class="social-row">
              <button type="button" class="btn btn-light w-100">Continue with Google</button>
              <button type="button" class="btn btn-light w-100">Continue with Facebook</button>
            </div> -->

            <p class="auth-alt">Don’t have an account? <a href="{{ route('signup.user') }}" class="auth-link">Create one</a></p>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection