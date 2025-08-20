@extends('frontend.master')

@section('title')
    Privacy Policy
@endsection

@section('content')

<section class="section-padding policy">
  <div class="container">
    <div class="section-title">
      <span class="title">policy</span>
      <h2 class="sub-title">Privacy Policy</h2>
    </div>

    @forelse ($privacyPolicy as $item)
      <div class="card mb-12">
        @if (!empty($item->updated_at))
          <p class="muted" style="margin-bottom:10px;">
            Last updated: {{ \Carbon\Carbon::parse($item->updated_at)->format('F d, Y') }}
          </p>
        @endif

        <div class="rich">
          {!! $item->privacyPolicy !!}
        </div>
      </div>
    @empty
      <div class="card">
        <p>No policy content available.</p>
      </div>
    @endforelse
  </div>
</section>

@endsection
