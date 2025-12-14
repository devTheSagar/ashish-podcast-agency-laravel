@extends('frontend.master')

@section('title')
    Case Studies
@endsection
<style>
  .case-grid {
  display: grid;
  grid-template-columns: repeat(1, 1fr); /* default 1 column for mobile */
  gap: 20px; /* space between cards */
}

/* For tablets */
@media (min-width: 768px) {
  .case-grid {
    grid-template-columns: repeat(2, 1fr); /* 2 cards per row */
  }
}

/* For desktops */
@media (min-width: 1200px) {
  .case-grid {
    grid-template-columns: repeat(4, 1fr); /* 4 cards per row */
  }
}

/* Optional: make cards stretch to same height */
.case-item .card {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.case-item .card-body {
  flex-grow: 1; /* fill vertical space */
}

</style>

@section('content')

<section class="case-studies section-padding">
  <div class="container">
    <div class="section-title">
      <span class="title">Case Studies</span>
      <h2 class="sub-title">Our Work & Success Stories</h2>
    </div>

    <div class="case-grid">
      @forelse($caseStudies as $case)
        <div class="case-item">
          <div class="card h-100 case-card border-0 shadow-sm">
            <img src="{{ asset($case->caseStudyImage) }}" class="card-img-top" alt="Case Study Image">
            <div class="card-body">
              <h6 class="card-title">Case Study #{{ $loop->iteration }}</h6>
              <p class="card-text">{!! \Illuminate\Support\Str::limit(strip_tags($case->caseStudyDetails), 100) !!}</p>
            </div>
            <div class="card-footer bg-white border-0">
              <a href="{{ route('user.case-studies.show', ['id' => $case->id]) }}" class="btn btn-sm btn-primary w-100">Read More</a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <p>No case studies found.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>

@endsection