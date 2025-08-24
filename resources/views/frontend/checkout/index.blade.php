@extends('frontend.master')

@section('title')
  Checkout
@endsection

@section('content')

<section class="section-padding" style="margin-top: 5vh">
  <div class="container">
    <div class="grid">

      <!-- Sidebar: Order summary -->
      <aside class="order-side">
        <div class="card">
          <h2 class="pane-title">{{ $plan->service->serviceName }} — {{ $plan->planName }} Plan</h2>

          <div class="price-row">
            <span class="new">${{ number_format($plan->planPrice, 2) }}</span>
            <span class="off">Total</span>
          </div>

          @if(!empty($plan->planDuration))
            <p class="muted">Duration: <strong>{{ $plan->planDuration }}</strong> days</p>
          @endif

          <h3 class="mt-10">Plan Features</h3>
          <ul class="feature-list">
            @foreach (json_decode($plan->planFeatures, true) as $feature)
              <li>{{ $feature }}</li>
            @endforeach
          </ul>
        </div>
      </aside>

      <!-- Main: Checkout form -->
      <main class="order-main">
        <div class="card order-form">
          <h3 class="pane-title">Place Order</h3>

          <div class="pay-card">
            <div class="pay-row">
              <div class="pay-ico" aria-hidden="true">💳</div>
              <div>
                <p class="pay-title">Payment instruction</p>
                <p class="pay-text">
                  Please pay <strong class="pay-amount">${{ number_format($plan->planPrice, 2) }}</strong> to our <strong>Payoneer</strong> email <span class="pay-kbd pay-amount">ashisbd851@gmail.com</span>
                  and paste the <span class="pay-kbd">Transaction ID</span> below to confirm your order. If you want to use another payment method, please <a href="{{ route('user.message') }}"><u>contact us</u></a>.
                </p>
              </div>
            </div>
          </div>


          <form action="{{ route('user.order') }}" method="POST" novalidate>
            @csrf
            <input type="hidden" name="planId" value="{{ $plan->id }}">

            <div class="input-box">
              <label for="name">Name</label>
              <input
                type="text"
                id="name"
                name="name"
                class="input-control @error('name') is-invalid @enderror"
                value="{{ old('name', auth()->user()->name ?? '') }}"
                placeholder="Your full name">
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="input-box">
              <label for="email">Email address</label>
              <input
                type="email"
                id="email"
                name="email"
                class="input-control @error('email') is-invalid @enderror"
                value="{{ old('email', auth()->user()->email ?? '') }}"
                placeholder="you@example.com">
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="input-box">
              <label for="phone">Phone Number</label>
              <input
                type="tel"
                id="phone"
                name="phone"
                class="input-control @error('phone') is-invalid @enderror"
                value="{{ old('phone') }}"
                placeholder="+1 555 000 1234">
              @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="input-box">
              <label for="transactionId">Transaction ID</label>
              <input
                type="text"
                id="transactionId"
                name="transactionId"
                class="input-control @error('transactionId') is-invalid @enderror"
                value="{{ old('transactionId') }}"
                placeholder="e.g., 9AB12345C6789012">
              @error('transactionId') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="input-box">
              <label for="link">Your Podcast Link</label>
              <input
                type="url"
                id="link"
                name="link"
                class="input-control @error('link') is-invalid @enderror"
                value="{{ old('link') }}"
                placeholder="https://">
              @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="input-box">
              <label>Targeted Countries</label>

              <label class="remember">
                <input type="checkbox" name="country[]" value="USA" {{ in_array('USA', (array)old('country', [])) ? 'checked' : '' }}>
                <span>USA</span>
              </label>

              <label class="remember">
                <input type="checkbox" name="country[]" value="Canada" {{ in_array('Canada', (array)old('country', [])) ? 'checked' : '' }}>
                <span>Canada</span>
              </label>

              <label class="remember">
                <input type="checkbox" name="country[]" value="UK" {{ in_array('UK', (array)old('country', [])) ? 'checked' : '' }}>
                <span>UK</span>
              </label>

              <label class="remember">
                <input type="checkbox" name="country[]" value="Australia" {{ in_array('Australia', (array)old('country', [])) ? 'checked' : '' }}>
                <span>Australia</span>
              </label>

              <label class="remember">
                <input type="checkbox" name="country[]" value="Germany" {{ in_array('Germany', (array)old('country', [])) ? 'checked' : '' }}>
                <span>Germany</span>
              </label>

              <label class="remember">
                <input type="checkbox" name="country[]" value="Finland" {{ in_array('Finland', (array)old('country', [])) ? 'checked' : '' }}>
                <span>Finland</span>
              </label>

              <label class="remember">
                <input type="checkbox" name="country[]" value="India" {{ in_array('India', (array)old('country', [])) ? 'checked' : '' }}>
                <span>India</span>
              </label>

              @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="input-box">
              <label for="additionalText">Additional Text</label>
              <textarea
                id="additionalText"
                name="additionalText"
                rows="4"
                class="input-control @error('additionalText') is-invalid @enderror"
                placeholder="Anything else we should know?">{{ old('additionalText') }}</textarea>
              @error('additionalText') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="btn-wrap">
              <button type="submit" class="btn" style="width:100%;">Confirm Order</button>
            </div>
          </form>
        </div>
      </main>

    </div>
  </div>
</section>

@endsection
