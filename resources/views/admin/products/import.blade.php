@extends('layouts.admin')
@section('title', 'Import Products')

@section('content')
<h1 class="text-2xl font-bold mb-6">Import Products</h1>

<form action="{{ route('admin.products.import.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow w-full md:w-2/3">
    @csrf

    <div class="mb-4">
        <label class="block font-semibold">Upload Excel File</label>
        <input type="file" name="file" accept=".xlsx,.xls" class="border w-full px-3 py-2 rounded" required>
    </div>

    <p class="text-gray-600 text-sm mb-4">
        Excel must contain: <strong>name, price, image_url</strong><br>
        Image URL must be JPG or PNG. System will convert it into <strong>WEBP</strong>.
    </p>

    <button class="bg-purple-600 text-white px-4 py-2 rounded">Import</button>
</form>
@endsection
