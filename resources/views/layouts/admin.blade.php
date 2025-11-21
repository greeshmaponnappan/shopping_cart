<!DOCTYPE html>
<html>
<head>
    <title>Admin - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-gray-800 text-white p-4">
    <div class="container mx-auto flex justify-between">
        <h1 class="font-bold">Admin Panel</h1>
        <a href="{{ route('admin.products.index') }}">Products</a>
    </div>
</nav>

<div class="container mx-auto mt-8">
    @yield('content')
</div>

</body>
</html>
