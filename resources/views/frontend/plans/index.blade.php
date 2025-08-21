@extends('frontend.master')

@section('title')
    Plan Details 
@endsection

@section('content')

<section class="section-padding service-details">
  <div class="container">
    <div class="grid">

      <!-- LEFT: main content -->
      <div class="service-main">
        <!-- header -->
        <div class="service-header card">
          <h2>{{$planDetails->planName}}</h2>

          <div class="service-rating">
            <span class="avg">({{ number_format($averageRating, 1) }})</span>
            <span class="stars" aria-label="4.8 out of 5">
              @for ($i = 1; $i <= 5; $i++)
                  @if ($averageRating >= $i)
                      <i class="fas fa-star"></i> {{-- Full star --}}
                  @elseif ($averageRating >= ($i - 0.5))
                      <i class="fas fa-star-half-alt"></i> {{-- Half star --}}
                  @else
                      <i class="far fa-star"></i> {{-- Empty star --}}
                  @endif
              @endfor
            </span>
            <span class="reviews">(120 Reviews)</span>
          </div>

          <ul class="service-meta">
            <li>total clients - <span>{{count($planDetails->ratings)}}+</span></li>
            @if ($teamLead)
                <li>team lead - <span><a href="#">{{ $teamLead->memberName }}</a></span></li>
            @else
                <p>No team lead assigned yet.</p>
            @endif 
          </ul>
        </div>

        <!-- tabs -->
        <nav class="service-tabs" role="tablist" aria-label="Service sections">
          <button class="tab-btn active" data-tab="services" aria-controls="tab-services" aria-selected="true">services</button>
          <button class="tab-btn" data-tab="description" aria-controls="tab-description" aria-selected="false">description</button>
          <button class="tab-btn" data-tab="team" aria-controls="tab-team" aria-selected="false">team</button>
          <button class="tab-btn" data-tab="reviews" aria-controls="tab-reviews" aria-selected="false">reviews</button>
        </nav>

        <!-- panes -->
        <div class="tab-panes">
          <!-- SERVICES -->
          <section id="tab-services" class="tab-pane active" role="tabpanel" aria-labelledby="services">
            <div class="card">
              <h3 class="mb-16">services</h3>

              <!-- accordion -->
              <div class="accordion" id="service-accordion">

                <details class="acc-item" open>
                  <summary class="acc-head">
                    <span>Launch & Platform Optimization</span>
                    <small>4 tasks | ~1 week</small>
                  </summary>
                  <div class="acc-body">
                    <ul class="bullet-list">
                      @foreach (json_decode($planDetails->planFeatures, true) as $feature)
                        <li>{{ $feature }}</li>
                      @endforeach
                    </ul>
                  </div>
                </details>

              </div>
              <!-- /accordion -->
            </div>
          </section>

          <!-- DESCRIPTION -->
          <section id="tab-description" class="tab-pane" role="tabpanel">
            <div class="card">
              <h3 class="mb-16">description</h3>
              <p>{!! $planDetails->planDescription !!}</p>
            </div>
          </section>

          <!-- TEAM -->
          <section id="tab-team" class="tab-pane" role="tabpanel">
            @foreach ($planDetails->teams as $team)
              <div class="card" style="margin-bottom: 5vh">
                <h3 class="mb-16">{{ $team->position === 1 ? 'Team Lead' : 'Team Member' }}</h3>
                <div class="team-lead">
                  <div class="lead-photo">
                    <img src="{{ asset($team->memberImage) }}" alt="team image">
                  </div>
                  <div class="lead-text">
                    <h4>{{ $team->memberName }}</h4>
                    <ul class="lead-stats">
                      <li>⭐ {{$team->memberRating}} Rating</li>
                      <li>🎧 {{ $team->totalReview }}+ Active Clients</li>
                      <li>🌎 USA • Canada • Australia</li>
                    </ul>
                  </div>
                </div>
                <p>{!! $team->memberDescription !!}</p>
              </div>
            @endforeach
          </section>

          <!-- REVIEWS -->
          <section id="tab-reviews" class="tab-pane" role="tabpanel">
            <div class="card">
              <h3 class="mb-16">client feedback</h3>

              <div class="rating-summary">
                <div class="rating-box">
                  <div class="rating-number">{{ number_format($averageRating, 1) }}</div>
                  <div class="rating-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($averageRating >= $i)  
                            <i class="fas fa-star"></i> {{-- Full star --}}
                        @elseif ($averageRating >= ($i - 0.5))
                            <i class="fas fa-star-half-alt"></i> {{-- Half star --}}
                        @else
                            <i class="far fa-star"></i> {{-- Empty star --}}
                        @endif
                    @endfor
                  </div>
                  <div class="rating-count">{{count($planDetails->ratings)}} Reviews</div>
                </div>
                <div class="rating-bars">
                  @for ($i = 5; $i >= 1; $i--)
                      <div class="bar">
                          <span>{{ $i }} Star</span>
                          <div class="track">
                              <i style="width: {{ $starsPercent[$i] ?? 0 }}%"></i>
                          </div>
                          <em>{{ $starsPercent[$i] ?? 0 }}%</em>
                      </div>
                  @endfor
                </div>
              </div>

              <!-- Reviews Filter -->
              <div class="rf-row">
                <h3 class="pane-title">reviews</h3>
                <form id="reviewFilterForm" class="rf-form" action="#" method="GET">
                  <label for="reviewFilter" class="sr-only">Filter reviews</label>
                  <div class="select-wrap">
                    <select id="reviewFilter" name="rating" class="input-control">
                      <option value="">All Reviews</option>
                      <option value="5">5 Stars</option>
                      <option value="4">4 Stars</option>
                      <option value="3">3 Stars</option>
                      <option value="2">2 Stars</option>
                      <option value="1">1 Star</option>
                    </select>
                    <span class="chev" aria-hidden="true"></span>
                  </div>
                </form>
              </div>

              <!-- Reviews list -->
              <div class="reviews-list" id="reviewsList">
                {{-- @foreach ($planDetails->ratings as $rating)
                  <article class="review" data-rating="{{ $rating->planRating }}">
                    <div class="avatar"><img src="img/review/1.png" alt="reviewer"></div>
                    <div>
                      <h4>{{ $rating->clientName }}</h4>
                      <div class="row-1">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $rating->planRating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                      </div>
                      <p>{{ $rating->clientReview }}</p>
                    </div>
                  </article>
                @endforeach --}}
                @foreach (($planDetails->ratings ?? []) as $rating)
                  @php
                    $name  = trim($rating->clientName ?? '');
                    $parts = preg_split('/[\s\-]+/u', $name, -1, PREG_SPLIT_NO_EMPTY);
                    if (empty($parts)) {
                        $initials = '?';
                    } elseif (count($parts) === 1) {
                        $initials = mb_strtoupper(mb_substr($parts[0], 0, 1, 'UTF-8'), 'UTF-8');
                    } else {
                        $first = mb_substr($parts[0], 0, 1, 'UTF-8');
                        $last  = mb_substr($parts[count($parts)-1], 0, 1, 'UTF-8');
                        $initials = mb_strtoupper($first.$last, 'UTF-8'); // "sagar biswas" -> "SB"
                    }
                    $photo = $rating->clientPhoto ?? null;
                  @endphp

                  <article class="review" data-rating="{{ $rating->planRating }}">
                    <div class="avatar">
                      @if($photo)
                        <img
                          src="{{ $photo }}"
                          alt="{{ $rating->clientName }}"
                          onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <span class="avatar-initial" aria-hidden="true" style="display:none;">{{ $initials }}</span>
                      @else
                        <span class="avatar-initial" aria-hidden="true">{{ $initials }}</span>
                      @endif
                    </div>

                    <div>
                      <h4>{{ $rating->clientName }}</h4>
                      <div class="row-1">
                        @for ($i = 1; $i <= 5; $i++)
                          @if ($i <= (int)$rating->planRating)
                            <i class="fas fa-star"></i>
                          @else
                            <i class="far fa-star"></i>
                          @endif
                        @endfor
                      </div>
                      <p>{{ $rating->clientReview }}</p>
                    </div>
                  </article>
                @endforeach
              </div>

              <!-- No results message -->
              <p class="muted" id="noReviewsMsg" style="display:none; margin-top:8px;">
                No reviews match this filter.
              </p>

              <!-- Load more -->
              <button class="btn" id="loadMoreReviews" type="button">more reviews</button>
            </div>
          </section>
        </div>
        <!-- /panes -->
      </div>
      <!-- /LEFT -->

      <!-- RIGHT: sidebar -->
      <aside class="service-side">
        <div class="card">
          <div class="preview">
            <div class="preview-media">
              <img src="{{ asset($planDetails->service->serviceImage) }}" class="w-100" alt="course img">
              {{-- <button class="play-btn" aria-label="Play preview">▶</button> --}}
            </div>
            {{-- <p class="center">Service Preview</p> --}}
          </div>

          <div class="price-row">
            @php
                $newPrice = $planDetails->planPrice;
                $oldPrice = $newPrice + ($newPrice * 0.20); // 20% higher than new price
            @endphp
            <span class="old">${{ number_format($oldPrice, 0) }}</span>
            <span class="new">${{ number_format($newPrice, 0) }}</span>
            <span class="off">20% Off</span>
          </div>

          <h3 class="mb-12">Plan Features</h3>
          <ul class="feature-list">
            @foreach (json_decode($planDetails->planFeatures, true) as $feature)
              <li>{{ $feature }}</li>
            @endforeach
          </ul>

          <a href="{{ route('user.checkout', ['id' => $planDetails->id]) }}" class="btn" style="width:100%; text-align: center; margin-top: 20px;">get started</a>
        </div>
      </aside>
      <!-- /RIGHT -->

    </div>
  </div>
</section>

@endsection
