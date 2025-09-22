@extends('layouts.app')
@section('content')

<div class="flex flex-col gap-4 bg-white p-6 rounded shadow-md min-h-screen items-center justify-center">
    <img src="{{$product->image_url}}" alt="Product Image" class="w-1/4 h-auto mx-auto">

    <form action="{{route('admin.update',$product)}}" method="POST" class="w-22 md-w-40 mx-auto space-y-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ $product->name }}" class="border border-gray-300 rounded px-2 py-1 w-full">
            <label for="price">Price</label>
            <input type="text" id="price" name="price" value="{{ $product->price }}" class="border border-gray-300 rounded px-2 py-1 w-full">
            <label for="stock">stock</label>
            <input type="text" id="stock" name="stock" value="{{ $product->stock }}" class="border border-gray-300 rounded px-2 py-1 w-full">
            <label for="image_url">Image</label>
            <input type="file" id="image_url" name="image_url"  class="border border-gray-300 rounded px-2 py-1 w-full" />
            <button class="px-4 py-2 rounded text-white bg-blue-400">Update Product</button>

        </form>
</div>
@endsection