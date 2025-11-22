<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Top Navbar -->
    <nav class="bg-gray-800 text-white px-6 py-4 shadow">
        <div class="flex justify-between items-center">
            <h1 class="font-bold text-xl">Admin Panel</h1>

            <div class="flex gap-6">
                <a href="{{ route('home') }}" class="hover:text-gray-300">Visit Shop</a>
                <a href="{{ route('admin.logout') }}" class="hover:text-gray-300">Logout</a>

            </div>
        </div>
    </nav>

    <div class="flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow h-screen p-6">
            <nav class="space-y-3">

                <a href="{{ route('admin.products.index') }}"
                   class="block px-3 py-2 rounded 
                   {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                    Products
                </a>

                <a href="#"
                   class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-200">
                    Orders
                </a>

                <a href="#"
                   class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-200">
                    Coupons
                </a>

                <a href="#"
                   class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-200">
                    Settings
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>

</body>
</html>
