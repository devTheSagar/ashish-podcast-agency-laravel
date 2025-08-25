@extends('frontend.master')

@section('title')
    User Account
@endsection

@section('content')

<section class="section-padding">
  <div class="container">

    {{-- flash/status --}}
    <div id="message-area" class="mb-12">
      @foreach (['status','success','message','error'] as $key)
        @if (session($key))
          <div class="alert">{{ session($key) }}</div>
        @endif
      @endforeach
    </div>

    <div class="grid account-grid">
      {{-- LEFT: Aside --}}
      <aside class="account-aside">
        <div class="card">
          <div class="account-user">
            <div class="avatar">
              @php $avatar = null; @endphp
              @if($avatar)
                <img src="{{ $avatar }}" alt="{{ Auth::user()->name }}">
              @else
                <div class="avatar-fallback">{{ mb_strtoupper(mb_substr(Auth::user()->name,0,1)) }}</div>
              @endif
            </div>
            <div>
              <h3 class="u-name">{{ Auth::user()->name }}</h3>
              <p class="u-email">{{ Auth::user()->email }}</p>
            </div>
          </div>

          <nav class="account-nav">
            <button class="anav active" data-pane="#pane-overview">Overview</button>
            <button class="anav" data-pane="#pane-orders">Orders</button>
            {{-- <button class="anav" data-pane="#pane-billing">Billing & Payments</button> --}}
            <button class="anav" data-pane="#pane-security">Security</button>
            {{-- <button class="anav" data-pane="#pane-settings">Settings</button> --}}

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout.user') }}" class="mt-10">
              @csrf
              <button type="submit" class="anav danger">Log out</button>
            </form>
          </nav>
        </div>
      </aside>

      {{-- RIGHT: Main --}}
      <main class="account-main">
        {{-- Overview --}}
        <div id="pane-overview" class="apane active">
          <div class="card">
            <h3 class="pane-title">Welcome back {{ Auth::user()->name }}</h3>
            <p class="muted">Manage your orders and account preferences from here.</p>
            <div class="grid kpi-grid mt-10">
              <div class="kpi">
                <span class="kpi-label">Total Orders</span>
                <strong class="kpi-value">{{ count($orders) ?? 0 }}</strong>
              </div>
              <div class="kpi">
                <span class="kpi-label">Active Plans</span>
                <strong class="kpi-value">
                  {{ $orders->where('status', 'pending')->count() }}
                </strong>

              </div>
              <div class="kpi">
                <span class="kpi-label">Total Spent</span>
                {{-- <strong class="kpi-value">${{ number_format($orders->sum('plan.planPrice'), 2) }}</strong> --}}
                <strong class="kpi-value">
                  ${{ number_format(
                        $orders->whereIn('status', ['pending','delivered'])
                              ->sum(fn($o) => data_get($o, 'plan.planPrice', 0)),
                        2
                    ) }}
                </strong>


              </div>
            </div>
          </div>
        </div>

        {{-- Orders --}}
        <div id="pane-orders" class="apane">
          <div class="card">
            <h3 class="pane-title">Your Orders</h3>
            @if(!empty($orders) && count($orders))
              <div class="table-wrap mt-10">
                <table class="table table-responsive">
                  <thead>
                        <tr>
                            <th>SL</th>
                            <th>Service</th>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>purchace date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->plan->service->serviceName }}</td>
                                <td>{{ $order->plan->planName }}</td>
                                <td>${{ $order->plan->planPrice }}</td>
                                <td>{{ $order->created_at->timezone('Asia/Dhaka')->format('d M, Y') }}</td>
                                {{-- <td>{{ $order->created_at->copy()->addDays($order->plan->planDuration)->timezone('Asia/Dhaka')->format('d M, Y ') }}</td> --}}
                                <td>{{ $order->created_at?->copy()?->addDays((int)($order->plan?->planDuration ?? 0))?->timezone('Asia/Dhaka')?->format('d M, Y') ?? '—' }}</td>
                                <td>{{ $order->status }}</td>
                                <td>
                                    <a href="{{ route('user.order-details', ['id' => $order->id]) }}" type="submit">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
              </div>
            @else
              <p class="muted">No orders found.</p>
            @endif
          </div>
        </div>

        {{-- Billing --}}
        {{-- <div id="pane-billing" class="apane">
          <div class="card">
            <h3 class="pane-title">Billing & Payments</h3>
            <p class="muted">Manage your invoices and payment methods.</p>

            <div class="grid billing-grid mt-10">
              <div class="col">
                <h4>Default Payment Method</h4>
                <div class="pay-card mt-10">
                  <p class="muted">No card on file.</p>
                  <div class="pay-actions">
                    <a href="#" class="btn btn-light">Add card</a>
                    <a href="#" class="btn">View invoices</a>
                  </div>
                </div>
              </div>
              <div class="col">
                <h4>Billing Address</h4>
                <p class="muted mt-10">Not set</p>
                <a href="#" class="btn btn-light mt-10">Edit address</a>
              </div>
            </div>
          </div>
        </div> --}}

        {{-- Security --}}
        <div id="pane-security" class="apane">
          <div class="card">
            <h3 class="pane-title">Security</h3>
            <ul class="feature-list">
              <li>Email: <strong>{{ Auth::user()->email }}</strong></li>
              <li>Last login: {{ isset($lastLoginAt) ? \Carbon\Carbon::parse($lastLoginAt)->diffForHumans() : '—' }}</li>
            </ul>
            <div class="divider"></div>
            <a href="{{ route('password.request') }}" class="btn">Change Password</a>
          </div>
        </div>

        {{-- Settings --}}
        {{-- <div id="pane-settings" class="apane">
          <div class="card">
            <h3 class="pane-title">Account Settings</h3>
            <form class="order-form mt-10" method="POST" action="#">
              @csrf
              <div class="grid mini-grid">
                <div class="input-box">
                  <label for="name">Full name</label>
                  <input type="text" id="name" name="name" class="input-control" value="{{ old('name', Auth::user()->name) }}" required>
                </div>
                <div class="input-box">
                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" class="input-control" value="{{ old('email', Auth::user()->email) }}" required>
                </div>
                <div class="input-box" style="grid-column: span 12;">
                  <button type="submit" class="btn">Save changes</button>
                </div>
              </div>
            </form>
            <p class="muted">Need to update more details? Contact support.</p>
          </div>
        </div> --}}

      </main>
    </div>
  </div>
</section>

{{-- Tiny JS to switch panes --}}
<script>
  (function(){
    const navs = document.querySelectorAll('.account-nav .anav');
    const panes = document.querySelectorAll('.account-main .apane');

    function activate(target){
      panes.forEach(p => p.classList.remove('active'));
      navs.forEach(n => n.classList.remove('active'));
      const pane = document.querySelector(target);
      const btn  = Array.from(navs).find(n => n.dataset.pane === target);
      if(pane) pane.classList.add('active');
      if(btn)  btn.classList.add('active');
    }

    navs.forEach(btn => {
      btn.addEventListener('click', function(){
        const target = this.dataset.pane;
        if(target) activate(target);
      });
    });
  })();
</script>

{{-- Minimal fallback avatar styling --}}
<style>
  .avatar-fallback{
    width:100%; height:100%;
    display:flex; align-items:center; justify-content:center;
    background: var(--bg-white);
    color: var(--main-color);
    font-weight:700; font-size:22px;
  }
</style>

@endsection
