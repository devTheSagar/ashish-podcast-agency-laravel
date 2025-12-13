@extends('frontend.master')

@section('title')
    Case Studies
@endsection

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