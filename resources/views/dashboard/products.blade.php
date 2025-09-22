@extends('layouts.app')

@section('content')
<div class="flex" >

<x-aside activePage="products" />

<div class="container mx-auto py-8  w-full ">
        <div class="w-full px-4 flex flex-col gap-4">
            <h2 class="text-2xl font-semibold mb-4">Products</h2>

            <form action="" class="flex items center gap-2 md:gap:4 max-w-[400px] md:min-w-[700px]">
            <input type="text" placholder="search" value="" name="q" class="border-[#333]  rounded-lg px-2 lg:px-4 py-2 flex-1"/>
            <button class="bg-blue-600 text-white font-semibold px-4 rounded-lg">Search</button>
        </form>
            <table class="w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-start border-b border-gray-200">ID</th>
                        <th class="py-2 px-4 text-start border-b border-gray-200">Name</th>
                        <th class="py-2 px-4 text-start border-b border-gray-200">Price</th>
                        <th class="py-2 px-4 text-start border-b border-gray-200">Stock</th>
                        <th class="py-2 px-4 text-start border-b border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $product->id }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $product->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">${{ $product->price }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $product->stock }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">
                            <a href="{{route('admin.edit', $product)}}" class="text-blue-500 hover:underline block">Edit</a>
                           <form action="{{ route('admin.delete', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>

    </div>
@endsection