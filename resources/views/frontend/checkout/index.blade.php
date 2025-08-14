@extends('frontend.master')

@section('title')
    Checkout 
@endsection

@section('content')
    <!-- breadcrumb start -->
  <div class="breadcrumb-nav">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item"><a href="courses.html">courses</a></li>
          <li class="breadcrumb-item active" aria-current="page">course details</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- breadcrumb end -->

  <!-- course details section start -->
  <section class="course-details section-padding">
    <div class="container">
      <div class="row">
        
        <div class="col-lg-4">
          <!-- course sidebar start -->
          <div class="course-sidebar box">
            <h2>{{ $plan->service->serviceName }} {{$plan->planName}} Plan</h2>
            <div class="price d-flex align-items-center mb-3">
              {{-- <span class="price-old text-decoration-line-through">$100</span> --}}
              <span>Total</span>
              <span class="price-new">${{ $plan->planPrice }}</span>
              {{-- <span class="price-discount">51% Off</span> --}}
            </div>
            <h3 class="mb-3">Plan Features</h3>
            <ul class="features-list">
              @foreach (json_decode($plan->planFeatures, true) as $feature)
                <li><i class=""></i> {{ $feature }}</li>
              @endforeach
            </ul>
          </div>
          <!-- course sidebar end -->
        </div>

        <div class="col-lg-8">
            <!-- course curriculum start -->
            <div class="tab-pane fade show active" id="course-curriculum" role="tabpanel" aria-labelledby="course-curriculum-tab">
              <div class="course-curriculum box">
                <h3 class="text-capitalize mb-4">place order</h3>
                <h3 class="text-capitalize mb-4">to place order, you have to pay <b>${{ $plan->planPrice }}</b> in this paypal account and put the transaction id in the transaction id box</h3>
                <!-- order start -->
                <form action="{{ route('user.order') }}" method="POST">
                  @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control @error('name') is-invalid @enderror" id="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control @error('email') is-invalid @enderror" id="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" id="phone">
                        @error('number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="transaction-id" class="form-label">Transaction Id</label>
                        <input type="text" name="transactionId" class="form-control @error('transactionId') is-invalid @enderror" value="{{ old('transactionId') }}" id="transaction-id">
                        @error('transactionId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="transaction-id" class="form-label">Your Podcast Link</label>
                        <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" id="transaction-id">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                      <label for="targeted-country" class="form-label">Your Targeted Country</label>
                      <div class="row">
                        <div class="col-md-6">
                              {{-- hidden field to pass plan id  --}}
                              <input type="hidden" name="planId" value="{{ $plan->id }}">

                              <div class="form-check">
                                  <input class="form-check-input" name="country[]" type="checkbox" value="USA" id="usa">
                                  <label class="form-check-label" for="usa">USA</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" name="country[]" type="checkbox" value="Canada" id="canada">
                                  <label class="form-check-label" for="canada">Canada</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" name="country[]" type="checkbox" value="UK" id="uk">
                                  <label class="form-check-label" for="uk">UK</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" name="country[]" type="checkbox" value="Australia" id="australia">
                                  <label class="form-check-label" for="australia">Australia</label>
                              </div>
                        </div>
                        <div class="col-md-6">
                              <div class="form-check">
                                  <input class="form-check-input" name="country[]" type="checkbox" value="Germany" id="germany">
                                  <label class="form-check-label" for="germany">Germany</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" name="country[]" type="checkbox" value="Finland" id="finland">
                                  <label class="form-check-label" for="finland">Finland</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" name="country[]" type="checkbox" value="India" id="india">
                                  <label class="form-check-label" for="india">India</label>
                              </div>
                          </div>
                      </div>
                      @error('country')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="mb-3">
                        <label for="additional-text" class="form-label">Additonal Text</label>
                        <textarea name="additionalText" class="form-control @error('additionalText') is-invalid @enderror" id="additional-text" rows="3">{{old('additionalText')}}</textarea>
                        @error('additionalText')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    {{-- <div  class="mb-3">
                        <input class="form-check-input" type="checkbox" name="agree" id="checkDefault">
                        <label class="form-check-label" for="checkDefault">
                            I agree to the <a href="#">terms and conditions</a> and <a href="#">privacy policy</a>
                        </label>
                        @error('agree')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="btn-wrap mt-3">
                        <button type="submit" class="btn btn-theme btn-block">Confirm Order</button>
                        <!-- <a href="#" type="button" class="btn btn-theme btn-block">enroll now</a> -->
                    </div>
                </form>
                <!-- order end -->
              </div>
            </div>
            <!-- course curriculum end -->
        </div>
      </div>
    </div>
  </section>
  <!-- course details section end -->
@endsection