@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Products</h1>

    <div>
        <a href="{{ route('admin.products.import') }}"
           class="bg-yellow-600 text-white px-4 py-2 rounded mr-2">Import</a>

        <a href="{{ route('admin.products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">Add Product</a>
    </div>
</div>

<div class="bg-white shadow rounded p-4">
    <table class="min-w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Price</th>
                <th class="px-4 py-2 text-left">Image</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $product->id }}</td>
                <td class="px-4 py-2">{{ $product->name }}</td>
                <td class="px-4 py-2">₹{{ number_format($product->price,2) }}</td>
                <td class="px-4 py-2">
                    @if($product->image)
                        <img src="{{ asset('storage/products/'.$product->image) }}" class="h-12">
                    @endif
                </td>

                <td class="px-4 py-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 mr-2">Edit</a>

                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                          method="POST"
                          class="inline"
                          onsubmit="return confirm('Delete product?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
