@extends('frontend.master')

@section('title')
    Testimonials 
@endsection

@section('content')

<section class="section-padding testimonials" style="margin-top: 7vh">
  <div class="container">
    <div class="section-title">
      <span class="title" data-aos="fade-up" data-aos-duration="600">what clients say</span>
      <h2 class="sub-title" data-aos="fade-up" data-aos-duration="600">Testimonials</h2>
    </div>

    <div class="grid testimonials-grid">
      @foreach ($testimonials as $testimonial)
        <!-- item -->
        <article class="testimonial-item" data-aos="fade-up" data-aos-duration="600">
          <div class="t-card">
            <div class="t-head">
              <div class="t-avatar">
                <img src="{{ $testimonial->photo ?? asset('img/review/default.png') }}" alt="{{ $testimonial->name }}">
              </div>
              <div class="t-id">
                <h3>{{ $testimonial->name }}</h3>
                <p>{{ $testimonial->designation }}</p>
              </div>
            </div>

            <div class="t-stars" aria-label="{{ $testimonial->rating }} out of 5">
              @php $rating = $testimonial->rating; @endphp
              {{-- full stars --}}
              @for ($i = 0; $i < $rating; $i++)
                <i class="fas fa-star"></i>
              @endfor
              {{-- empty stars --}}
              @for ($i = $rating; $i < 5; $i++)
                <i class="far fa-star"></i>
              @endfor
            </div>

            <blockquote class="t-quote" data-expanded="false">
              @php
                  $full  = $testimonial->testimonial;
                  $limit = 100;
                  $isLong = \Illuminate\Support\Str::length($full) > $limit;
                  $short = \Illuminate\Support\Str::limit($full, $limit, '');
              @endphp
              <span class="text-content">{{ $isLong ? $short . '…' : $full }}</span>
            </blockquote>


            @if($isLong)
                <a href="#" class="see-more" 
                  data-full="{{ $full }}" 
                  data-short="{{ $short . '…' }}">
                  See more
                </a>
            @endif

            <div class="t-meta">
              <span>{{ $testimonial->date }}</span>
            </div>
          </div>
        </article>
        <!-- /item -->
      @endforeach
    </div>

    <!-- optional CTA -->
    <div class="t-cta">
      <a href="{{ route('user.message') }}" class="btn">work with us</a>
    </div>
  </div>
</section>


{{-- for see more/see less functionality  --}}
<script>
  document.addEventListener('click', function(e){
      const link = e.target.closest('.see-more');
      if(!link) return;

      e.preventDefault();
      const bq = link.previousElementSibling; // blockquote before the link
      const textEl = bq.querySelector('.text-content');
      const expanded = bq.getAttribute('data-expanded') === 'true';

      if(expanded){
          textEl.textContent = link.dataset.short;
          bq.setAttribute('data-expanded', 'false');
          link.textContent = "See more";
      } else {
          textEl.textContent = link.dataset.full;
          bq.setAttribute('data-expanded', 'true');
          link.textContent = "See less";
      }
  });
</script>


@endsection