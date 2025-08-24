@extends('frontend.master')

@section('title')
  Reset Password
@endsection

@section('content')
<style>
  .text-danger{
      color: #dc3545;
  }
</style>
<section class="section-padding auth auth-login" style="margin-top: 5vh">
  <div class="container">
    <div class="grid auth-grid">

      {{-- Left: Helpful copy --}}
      <div class="auth-aside">
        <div class="auth-card">
          <h2 class="auth-title">Reset your password</h2>
          <p class="auth-text">
            Choose a strong password to secure your account. You can log in immediately after resetting.
          </p>
          <ul class="auth-points">
            <li>Minimum 8 characters recommended</li>
            <li>Mix letters, numbers & symbols</li>
            <li>Don’t reuse old passwords</li>
          </ul>
        </div>
      </div>

      {{-- Right: Form --}}
      <div class="auth-main">
        <div class="auth-card">
          <h3 class="auth-subtitle" style="text-align:center; margin-bottom: 5vh;">Create your new password</h3>

          {{-- Session alerts --}}
          <div id="message-area">
            @foreach (['status','success','message','error'] as $key)
              @if (session($key))
                <div class="alert">{{ session($key) }}</div>
              @endif
            @endforeach
          </div>

          <form class="auth-form" action="{{ route('password.update') }}" method="POST" novalidate>
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="input-box">
              <label for="email">Email address</label>
              <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                class="input-control @error('email') is-invalid @enderror"
                placeholder="you@example.com"
                required
              >
              @error('email')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-box">
              <label for="password">New password</label>
              <div class="password-wrap">
                <input
                  type="password"
                  name="password"
                  id="password"
                  class="input-control @error('password') is-invalid @enderror"
                  placeholder="••••••••"
                  required
                  minlength="6"
                >
                <button type="button" class="pw-toggle" data-target="#password" aria-label="Show password">Show</button>
              </div>

              {{-- Optional strength meter (styled by your CSS) --}}
              <div class="pw-strength" id="pwStrength" aria-hidden="true" style="display:none;">
                <span class="bar"></span><span class="bar"></span><span class="bar"></span><span class="bar"></span>
                <span class="label">Weak</span>
              </div>

              @error('password')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-box">
              <label for="password_confirmation">Confirm password</label>
              <div class="password-wrap">
                <input
                  type="password"
                  name="password_confirmation"
                  id="password_confirmation"
                  class="input-control @error('password_confirmation') is-invalid @enderror"
                  placeholder="••••••••"
                  required
                  minlength="6"
                >
                <button type="button" class="pw-toggle" data-target="#password_confirmation" aria-label="Show password">Show</button>
              </div>
              <div class="match-hint" id="matchHint" style="display:none;">Passwords match ✅</div>

              @error('password_confirmation')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn w-100">Reset Password</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- Minimal JS: show/hide + lightweight strength & match hints (optional) --}}
<script>
  // Reusable binder (works on normal load + Turbo/PJAX/Livewire)
  function bindPwToggles(){
    // Delegated click handler
    document.addEventListener('click', function(e){
      const btn = e.target.closest('.pw-toggle');
      if (!btn) return;

      e.preventDefault();

      const wrap = btn.closest('.password-wrap');
      const input = wrap ? wrap.querySelector('input[type="password"], input[type="text"]') : null;
      if (!input) return;

      const isPwd = input.type === 'password';
      input.type = isPwd ? 'text' : 'password';
      btn.textContent = isPwd ? 'Hide' : 'Show';
    }, { passive: false });
  }

  // Run on initial DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bindPwToggles);
  } else {
    bindPwToggles();
  }

  // If you use Turbo/Livewire/PJAX, also re-bind on their events (safe to leave even if you don't use them)
  window.addEventListener('turbo:load', bindPwToggles);
  window.addEventListener('turbo:render', bindPwToggles);
  document.addEventListener('livewire:navigated', bindPwToggles);
  document.addEventListener('pjax:complete', bindPwToggles);

  /* --------- Strength + match (unchanged) --------- */
  const pw = document.getElementById('password');
  const meter = document.getElementById('pwStrength');
  const bars = meter ? meter.querySelectorAll('.bar') : [];
  const label = meter ? meter.querySelector('.label') : null;

  function scorePassword(val){
    let s = 0;
    if (!val) return s;
    if (val.length >= 8) s++;
    if (/[A-Z]/.test(val)) s++;
    if (/[0-9]/.test(val)) s++;
    if (/[^A-Za-z0-9]/.test(val)) s++;
    return s;
  }

  function renderStrength(s){
    bars.forEach((b,i)=> b.classList.toggle('on', i < s));
    if (label) label.textContent = ['Very weak','Weak','Fair','Good','Strong'][s] || 'Very weak';
  }

  if (pw && meter) {
    pw.addEventListener('input', () => {
      const s = scorePassword(pw.value);
      meter.style.display = pw.value ? 'flex' : 'none';
      renderStrength(s);
    });
  }

  const pc = document.getElementById('password_confirmation');
  const matchHint = document.getElementById('matchHint');
  function checkMatch(){
    if (!pc || !matchHint) return;
    const filled = pw.value && pc.value;
    matchHint.style.display = (filled && pw.value === pc.value) ? 'block' : 'none';
  }
  if (pw && pc) {
    pw.addEventListener('input', checkMatch);
    pc.addEventListener('input', checkMatch);
  }
</script>

@endsection
