@props(['activePage'])
<aside class="w-60 flex flex-col bg-gray-800 text-white  min-h-screen">
    <h2 class="text-lg font-semibold mb-4 px-2 py-2">Dashboard</h2>
    @if ($activePage == 'products')
    <a href="/dashboard/products" class="w-[100%] bg-[#F78a7a] block text-lg font-semibold px-6 py-2">Products</a>
    <a href="/dashboard/orders" class="w-full block text-lg font-semibold px-6 py-2">Orders</a>
    @elseif ($activePage == 'orders')
    <a href="/dashboard/products" class="w-full block text-lg font-semibold px-6 py-2">Products</a>
    <a href="/dashboard/orders" class="w-full bg-[#F78a7a] block px-6 text-lg font-semibold py-2">Orders</a>
    @else
    <a href="/dashboard/products" class="w-full block text-lg font-semibold px-6 py-2">Products</a>
    <a href="/dashboard/orders" class="w-full  block px-6 text-lg font-semibold py-2">Orders</a>
    @endif   
</aside>
