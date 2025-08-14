@extends('frontend.master')

@section('title')
    Testimonials 
@endsection

@section('content')
    <!-- breadcrumb start -->
  <div class="breadcrumb-nav">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- breadcrumb end -->

  <!-- contact section start -->
  <section class="contact-section section-padding">
    <div class="container">
      <div class="row">
        @foreach ($testimonials as $testimonial)
            <div class="col-md-6 mb-5">
                <span>{{ $testimonial->date }}</span>
                <p class="m-0 p-0">{{ $testimonial->name }}</p>
                <p>{{ $testimonial->designation }}</p>
                {{-- showing stars  --}}
                <span class="average-stars">
                    @php
                        $rating = $testimonial->rating;
                    @endphp

                    {{-- Show full stars --}}
                    @for ($i = 0; $i < $rating; $i++)
                        <i class="fas fa-star"></i>
                    @endfor

                    {{-- Show empty stars for the rest --}}
                    @for ($i = $rating; $i < 5; $i++)
                        <i class="far fa-star"></i>
                    @endfor
                </span>

                <p>{{ $testimonial->testimonial }}</p>
                <p></p>
            </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- contact section end -->

@endsection