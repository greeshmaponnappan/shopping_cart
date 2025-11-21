@extends('layouts.app')
@section('content')
<h3>Your Cart</h3>
@if(empty($cart))
  <p>Cart is empty</p>
@else
<table class="table">
  <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Line</th><th></th></tr></thead>
  <tbody>
    @php $subtotal = 0; @endphp
    @foreach($cart as $item)
      @php $line = $item['price'] * $item['quantity']; $subtotal += $line; @endphp
      <tr>
        <td>{{ $item['name'] }}</td>
        <td>₹{{ number_format($item['price'],2) }}</td>
        <td>{{ $item['quantity'] }}</td>
        <td>₹{{ number_format($line,2) }}</td>
        <td>
          <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
            @csrf
            <button class="btn btn-sm btn-danger">Remove</button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="mb-3">
  <strong>Subtotal: ₹{{ number_format($subtotal,2) }}</strong>
</div>

<form method="POST" action="{{ route('cart.coupon') }}" class="mb-3">
  @csrf
  <div class="input-group" style="max-width:400px">
    <input name="coupon" type="text" class="form-control" placeholder="Coupon code">
    <button class="btn btn-outline-secondary">Apply</button>
  </div>
</form>

<form method="POST" action="{{ route('cart.checkout') }}">
  @csrf
  <button class="btn btn-primary">Checkout</button>
</form>
@endif
@endsection
