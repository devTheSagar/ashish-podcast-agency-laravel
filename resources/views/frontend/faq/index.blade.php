@extends('frontend.master')

@section('title')
    Faq 
@endsection

@section('content')
    <!-- breadcrumb start -->
  <div class="breadcrumb-nav">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Faq</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- breadcrumb end -->

  <!-- contact section start -->
<section class="contact-section section-padding">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <h2 class="mb-3">Frequently Asked Questions</h2>
                <p class="text-muted">Find answers to the most common questions below.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="accordion" id="faqAccordion">
                    @foreach ($faqs as $faq)
                        @php
                            $collapseId = 'collapse' . $loop->index;
                            $headingId = 'heading' . $loop->index;
                        @endphp
                        <div class="accordion-item mb-3 border">
                            <h2 class="accordion-header" id="{{ $headingId }}">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                    {{ $faq->question }}?
                                </button>
                            </h2>
                            <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact section end -->


@endsection