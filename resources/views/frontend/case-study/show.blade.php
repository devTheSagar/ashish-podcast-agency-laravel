@extends('frontend.master')

@section('title')
    Case Study
@endsection

@section('content')

<section class="case-study-detail section-padding">
  <div class="container">
    <div class="section-title">
      <span class="title">Case Study</span>
      <h2 class="sub-title">Case Study #{{ $position ?? 1 }}</h2>
    </div>

    <div class="row">
      <div class="col-12 mb-4">

        <div class="card border-0 shadow-sm p-3">
          <div class="case-detail-wrap">
            <div class="case-thumb">
              <img src="{{ asset($caseStudy->caseStudyImage) }}" alt="Case Study Image">
            </div>

            <div class="case-content">
              <div class="case-meta">Case Study: <strong>#{{ $position ?? 1 }}</strong></div>
              <div class="case-details mb-3">
                {!! $caseStudy->caseStudyDetails !!}
              </div>
              <div class="d-flex gap-2 flex-wrap justify-content-center">
                <a href="{{ route('user.case-studies') }}" class="btn btn-outline-secondary">Back</a>
                <a href="{{ route('user.message') }}" class="btn btn-primary">Contact Us</a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('styles')
<style>
.case-detail-wrap {
  display: flex;
  flex-direction: column; /* stack content */
  align-items: center;    /* center image and text */
  text-align: center;     /* center text */
  gap: 20px;
}

/* Thumb wrapper centers image across all screens */
.case-detail-wrap .case-thumb {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
}

/* Image */
.case-detail-wrap .case-thumb img {
  display: block;
  margin: 0 auto;
  width: 100%;
  max-width: 500px; /* optional max width */
  height: auto;
  border-radius: 8px;
  object-fit: cover;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Text */
.case-detail-wrap .case-content {
  display: block;
  color: #333;
}

/* Meta */
.case-detail-wrap .case-meta {
  font-size: 0.9rem;
  color: #888;
}

/* Details */
.case-detail-wrap .case-details {
  font-size: 1rem;
  line-height: 1.7;
}

/* Buttons */
.case-detail-wrap .case-content .btn {
  padding: 10px 20px;
  border-radius: 5px;
  font-size: 0.95rem;
  cursor: pointer;
  text-decoration: none;
  display: inline-block;
  transition: all 0.3s ease;
}

.case-detail-wrap .case-content .btn-primary {
  background-color: #007bff;
  color: #fff;
  border: none;
}

.case-detail-wrap .case-content .btn-primary:hover {
  background-color: #0056b3;
}

.case-detail-wrap .case-content .btn-outline-secondary {
  background-color: transparent;
  color: #555;
  border: 1px solid #555;
}

.case-detail-wrap .case-content .btn-outline-secondary:hover {
  background-color: #555;
  color: #fff;
}

/* Dark mode - make text light and ensure buttons are readable */
body.dark-mode .case-detail-wrap,
body.dark-mode .case-detail-wrap .case-content,
body.dark-mode .case-detail-wrap .case-meta,
body.dark-mode .case-detail-wrap .case-details {
  color: #eaeaea;
}

body.dark-mode .case-detail-wrap .case-content .btn-outline-secondary {
  color: #eaeaea;
  border-color: #eaeaea;
}

body.dark-mode .case-detail-wrap .case-content .btn-outline-secondary:hover {
  background-color: #eaeaea;
  color: #111;
}

body.dark-mode .case-detail-wrap .case-content .btn-primary {
  color: #fff;
}
</style>
@endsection
