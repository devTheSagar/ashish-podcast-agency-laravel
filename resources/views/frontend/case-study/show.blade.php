@extends('frontend.master')

@section('title')
    Case Study
@endsection

@section('content')

<section class="case-study-detail section-padding">
  <div class="container">
    <div class="section-title">
      <span class="title">Case Study</span>
      <h2 class="sub-title">Case Study #{{ $caseStudy->id }}</h2>
    </div>

    <div class="row">
      <div class="col-12 mb-4">

        <div class="card border-0 shadow-sm p-3">
          <div class="case-detail-wrap">
            <div class="case-thumb">
              <img src="{{ asset($caseStudy->caseStudyImage) }}" alt="Case Study Image">
            </div>

            <div class="case-content">
              <div class="case-meta">Case Study ID: <strong>#{{ $caseStudy->id }}</strong></div>
              <div class="case-details mb-3">
                {!! $caseStudy->caseStudyDetails !!}
              </div>
              <div class="d-flex gap-2">
                <a href="{{ route('user.case-studies') }}" class="btn btn-outline-secondary">Back</a>
                <a href="#" class="btn btn-primary">Contact Us</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
