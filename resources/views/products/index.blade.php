@extends('layouts.app')
@section('title','Products')

@section('content')

<h4 class="page-header-title mb-3">Products</h4>

<div class="row g-4">
@foreach($products as $p)
    <div class="col-md-3 col-sm-6">
        <div class="card h-100 shadow-sm border-0">

            {{-- Image --}}
            <img src="{{ asset('storage/products/'.$p->image) }}"
                 class="card-img-top" style="height:200px;object-fit:cover;border-radius:8px 8px 0 0">

            <div class="card-body d-flex flex-column">

                <h6 class="fw-bold">{{ $p->name }}</h6>
                <p class="text-primary fw-semibold">₹{{ number_format($p->price,2) }}</p>

                <form method="POST" action="{{ route('cart.add', $p->id) }}" class="mt-auto">
                    @csrf
                    <button class="btn btn-primary w-100 mb-2">Add to Cart</button>
                    <a href="{{ route('products.show', $p->id) }}" class="btn btn-outline-secondary w-100">
                        View Details
                    </a>
                </form>

            </div>
        </div>
    </div>
@endforeach
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>

@endsection
