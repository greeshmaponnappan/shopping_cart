@extends('layouts.admin')
@section('title', 'Edit Product')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Product</h1>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow w-full md:w-2/3">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block font-semibold">Name</label>
        <input type="text" name="name" class="border w-full px-3 py-2 rounded" 
               value="{{ $product->name }}" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Price</label>
        <input type="number" name="price" class="border w-full px-3 py-2 rounded"
               step="0.01" value="{{ $product->price }}" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Current Image</label>
        @if($product->image)
            <img src="{{ asset('storage/products/'.$product->image) }}" class="h-16 mb-2">
        @endif

        <input type="file" name="image" accept="image/jpeg,image/png" class="border w-full px-3 py-2 rounded">
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Update
    </button>
</form>
@endsection
