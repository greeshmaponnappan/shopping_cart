<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Shop')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body { background:#f7f7f7; }
    .navbar-brand { font-weight:600; }
    .page-header-title { font-size:22px;font-weight:600; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
  <div class="container">

    {{-- Back Button (shows automatically except home) --}}
    @if(!request()->routeIs('home'))
      <a href="{{ url()->previous() }}" class="btn btn-light me-2">
        ← Back
      </a>
    @endif

    <a class="navbar-brand" href="{{ route('home') }}">My Shop</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-center">

        <li class="nav-item me-3">
          <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">
            🛒 Cart ({{ count(session('cart',[])) }})
          </a>
        </li>

      </ul>
    </div>

  </div>
</nav>

<div class="container py-4">
    @include('partials.flash')
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
