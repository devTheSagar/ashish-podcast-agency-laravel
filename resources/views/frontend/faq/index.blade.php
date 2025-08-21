@extends('frontend.master')

@section('title')
    FAQ
@endsection

@section('content')

<section class="section-padding">
  <div class="container">
    <div class="section-title">
      <span class="title">help center</span>
      <h2 class="sub-title">Frequently Asked Questions</h2>
    </div>

    <div class="accordion">
      @forelse ($faqs as $faq)
        <details class="acc-item" {{ $loop->first ? 'open' : '' }}>
          <summary class="acc-head">
            {{ rtrim($faq->question, '?') }}?
          </summary>
          <div class="acc-body">
            <div class="rich">
              {!! $faq->answer !!}
            </div>
          </div>
        </details>
      @empty
        <div class="card">
          <p>No FAQs available right now.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>

@endsection
