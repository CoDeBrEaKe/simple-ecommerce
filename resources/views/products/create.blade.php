@extends('layouts.app')
@section('content')

<div class="flex flex-col gap-4 bg-white p-6 rounded shadow-md min-h-screen items-center justify-center">

    <form action="{{ route('admin.store') }}" method="POST" class="w-22 md-w-40 mx-auto space-y-4" enctype="multipart/form-data">
        @csrf
       
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="" class="border border-gray-300 rounded px-2 py-1 w-full">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" value="" class="border border-gray-300 rounded px-2 py-1 w-full">
            <label for="stock">stock</label>
            <input type="number" id="stock" name="stock" value="" class="border border-gray-300 rounded px-2 py-1 w-full">
            <label for="image_url">Image</label>
            <input type="file" id="image_url" name="image_url"  class="border border-gray-300 rounded px-2 py-1 w-full" />
            <button class="px-4 py-2 rounded text-white bg-blue-400">Create Product</button>

        </form>
</div>
@endsection