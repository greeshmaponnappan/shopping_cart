@extends('layouts.app')
@section('title', $product->name)

@section('content')

<div class="row g-4">

    {{-- Product Image --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            @if($product->image)
                <img src="{{ asset('storage/products/'.$product->image) }}"
                     class="img-fluid rounded"
                     style="width: 100%; height:380px; object-fit:cover;">
            @else
                <img src="https://via.placeholder.com/600x400?text=No+Image"
                     class="img-fluid rounded">
            @endif
        </div>
    </div>

    {{-- Product Details --}}
    <div class="col-md-6">
        <div class="card border-0 p-3">

            <h2 class="fw-bold">{{ $product->name }}</h2>

            <p class="mt-2 text-muted">
                {!! nl2br(e($product->description)) !!}
            </p>

            <h3 class="text-primary fw-bold mt-3">
                ₹{{ number_format($product->price, 2) }}
            </h3>

            <hr>

            {{-- Add to Cart Form --}}
            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                @csrf

                {{-- Quantity --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Quantity</label>
                    <input type="number" name="quantity" value="1" min="1"
                           class="form-control w-25">
                </div>

                <button class="btn btn-success btn-lg w-100">
                    🛒 Add to Cart
                </button>
            </form>

        </div>
    </div>

</div>

@endsection
