@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($products as $product)
    <div class="bg-white p-4 rounded shadow">
      <a href="{{ route('products.show', 'product') }}">
        <img src="{{ $product->image ? asset('storage/'.$product->image) : '/placeholder.png' }}" class="h-40 w-full object-cover rounded">
        <h3 class="mt-2 font-semibold">{{ $product->name }}</h3>
      </a>
      <div class="flex items-center justify-between mt-2">

        <span class="text-lg font-bold">${{ number_format($product->price,2) }}</span>
        <span class="text-xs font-regular">{{ $product->stock,2 }} Left </span>
      </div>
      <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <input type="hidden" name="quantity" value="1">
        <button class="mt-2 w-full py-2 bg-blue-600 text-white rounded">Add to cart</button>
      </form>
    </div>
    @endforeach
  </div>

  <div class="mt-6">
    {{ $products->links() }}
  </div>
</div>
@endsection
