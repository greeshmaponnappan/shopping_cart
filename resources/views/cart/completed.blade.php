@extends('layouts.app')
@section('content')
<h3>Order #{{ $order->id }} — {{ ucfirst($order->status) }}</h3>
<p>Total: ₹{{ number_format($order->total,2) }}</p>
<ul>
  @foreach($order->items as $it)
    <li>{{ $it->product->name }} — {{ $it->quantity }} × ₹{{ number_format($it->unit_price,2) }}</li>
  @endforeach
</ul>
@endsection
