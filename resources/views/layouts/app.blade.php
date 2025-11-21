<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Shop')</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">My Shop</a>
    <div>
      <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">Cart ({{ count(session('cart',[])) }})</a>
    
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
