@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-md-6">
    @if($product->image)<img src="{{ asset($product->image) }}" class="img-fluid">@endif
  </div>
  <div class="col-md-6">
    <h2>{{ $product->name }}</h2>
    <p>{{ $product->description }}</p>
    <p><strong>₹{{ number_format($product->price,2) }}</strong></p>
    <form method="POST" action="{{ route('cart.add', $product->id) }}">
      @csrf
      <button class="btn btn-success">Add to cart</button>
    </form>
  </div>
</div>
@endsection
