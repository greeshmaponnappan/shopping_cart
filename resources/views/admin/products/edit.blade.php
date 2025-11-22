@extends('layouts.admin')
@section('title', 'Edit Product')

@section('content')

<a href="{{ route('admin.products.index') }}" 
   class="inline-block mb-4 text-blue-600 hover:underline">&larr; Back to Products</a>

<h1 class="text-2xl font-bold mb-6">Edit Product</h1>

{{-- Show Validation Errors --}}
@if ($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc ml-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
        <label class="block font-semibold">Price (₹)</label>
        <input type="number" name="price" class="border w-full px-3 py-2 rounded"
               step="0.01" value="{{ $product->price }}" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Current Image</label>

        @if($product->image)
            <img src="{{ asset('storage/products/'.$product->image) }}" 
                 class="h-20 w-20 object-cover rounded mb-3 border">
        @else
            <p class="text-gray-600 text-sm mb-3">No image uploaded.</p>
        @endif

        <input type="file" name="image" accept="image/jpeg,image/png" 
               class="border w-full px-3 py-2 rounded">
        <p class="text-gray-500 text-sm mt-1">Upload to replace existing image</p>
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Update Product
    </button>
</form>

@endsection
