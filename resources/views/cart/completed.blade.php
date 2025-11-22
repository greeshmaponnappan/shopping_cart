@extends('layouts.app')
@section('content')

<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h3 class="mb-3">
                Order #{{ $order->id }} 
                <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
            </h3>

            <h4 class="text-primary mb-3">
                Total Paid: ₹{{ number_format($order->total,2) }}
            </h4>

            <h5 class="mt-4 mb-3">Order Items</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Line Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $it)
                    <tr>
                        <td>{{ $it->product->name }}</td>
                        <td>{{ $it->quantity }}</td>
                        <td>₹{{ number_format($it->unit_price,2) }}</td>
                        <td>₹{{ number_format($it->total_price,2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('/') }}" class="btn btn-secondary">Continue Shopping</a>
                <a href="{{ route('cart.index') }}" class="btn btn-primary">Back to Cart</a>
            </div>

        </div>
    </div>

</div>

@endsection
