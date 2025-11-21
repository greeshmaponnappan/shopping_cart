@extends('layouts.app')
@section('title','Products')
@section('content')
<div class="row">
  @foreach($products as $p)
    <div class="col-md-3">
      <div class="card mb-3">
        @if($p->image)<img src="{{ asset($p->image) }}" class="card-img-top" style="height:160px;object-fit:cover">@endif
        <div class="card-body">
          <h5 class="card-title">{{ $p->name }}</h5>
          <p class="card-text">₹{{ number_format($p->price,2) }}</p>
          <form method="POST" action="{{ route('cart.add', $p->id) }}">
            @csrf
            <button class="btn btn-primary">Add to cart</button>
            <a href="{{ route('products.show', $p->id) }}" class="btn btn-outline-secondary">View</a>
          </form>
        </div>
      </div>
    </div>
  @endforeach
</div>
{{ $products->links() }}
@endsection
