@extends('layouts.app')
@section('title', 'Your Cart')

@section('content')

<a href="{{ route('home') }}" class="btn btn-light mb-3">← Continue Shopping</a>

<h3 class="fw-bold mb-4">Your Cart</h3>

@if(empty($cart))
    <div class="alert alert-info p-4 text-center">
        <h5>Your cart is empty</h5>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Browse Products</a>
    </div>
@else

<div class="row">

    {{-- Cart Table --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">

                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th width="120">Qty</th>
                            <th>Line Total</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $item)
                            @php 
                                $line = $item['price'] * $item['quantity']; 
                                $subtotal += $line; 
                            @endphp

                            <tr>
                                <td>
                                    <strong>{{ $item['name'] }}</strong>
                                </td>

                                <td>₹{{ number_format($item['price'],2) }}</td>

                                <td>
                                    <form method="POST" action="{{ route('cart.update', $item['id']) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                               class="form-control form-control-sm w-75">
                                        <button class="btn btn-sm btn-outline-secondary mt-1">Update</button>
                                    </form>
                                </td>

                                <td>₹{{ number_format($line,2) }}</td>

                                <td>
                                    <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-danger">
                                            Remove
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>

    {{-- Summary Sidebar --}}
    <div class="col-md-4">

        {{-- Coupon Box --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">

                <h5 class="fw-bold mb-3">Apply Coupon</h5>

                <form method="POST" action="{{ route('cart.coupon') }}">
                    @csrf
                    <div class="input-group">
                        <input name="coupon" type="text" class="form-control" placeholder="Enter coupon code">
                        <button class="btn btn-outline-secondary">Apply</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- Price Summary --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <h5 class="fw-bold mb-3">Price Summary</h5>

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($subtotal,2) }}</span>
                </div>

                @if(session('coupon'))
                <div class="d-flex justify-content-between text-success mb-2">
                    <span>Coupon ({{ session('coupon.code') }})</span>
                    <span>- ₹{{ number_format(session('coupon.value'),2) }}</span>
                </div>
                @endif

                <hr>

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span>
                        ₹{{ number_format(
                            $subtotal - (session('coupon.value') ?? 0), 2
                        ) }}
                    </span>
                </div>

                {{-- Checkout Button --}}
                <form method="POST" action="{{ route('cart.checkout') }}" class="mt-4">
                    @csrf
                    <button class="btn btn-primary btn-lg w-100">
                        Proceed to Checkout
                    </button>
                </form>

            </div>
        </div>

    </div>

</div>

@endif

@endsection
