@extends('frontend.master')

@section('title')
    User Account
@endsection

@section('content')
    <!-- breadcrumb start -->
  <div class="breadcrumb-nav">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item"><a href="index.html">User</a></li>
          <li class="breadcrumb-item active" aria-current="page">My Account</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- breadcrumb end -->

  <!-- content start  -->
  <div class="container mb-5">
    <div class="row">
        <div class="col-lg-12">
            <p>Welcome to your dashboard, where you can manage your orders and account settings.</p>
            <br>
            <p><b>Name:</b> {{ Auth::user()->name }}</p>
            <p><b>Email:</b> {{ Auth::user()->email }}</p>
            <a href="{{ route('password.request') }}">Change Password</a>
        </div>
    </div>
  </div>
  <!-- content end  -->
@endsection