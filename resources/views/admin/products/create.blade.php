@extends('layouts.admin')
@section('title', 'Add Product')

@section('content')

<a href="{{ route('admin.products.index') }}" 
   class="inline-block mb-4 text-blue-600 hover:underline">&larr; Back to Products</a>

<h1 class="text-2xl font-bold mb-6">Add Product</h1>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc ml-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow w-full md:w-2/3">
    @csrf

    <div class="mb-4">
        <label class="block font-semibold">Name</label>
        <input type="text" name="name" class="border w-full px-3 py-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Price</label>
        <input type="number" name="price" class="border w-full px-3 py-2 rounded" step="0.01" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Image (JPG/PNG)</label>
        <input type="file" name="image" accept="image/jpeg,image/png" class="border w-full px-3 py-2 rounded">
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
</form>
@endsection
