@extends('layouts.app')

@section('content')
@if (session('error'))
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
<div class="container max-auto py-8 flex items-center overflow-hidden">
    <div class="flex-col flex-1 gap-4   items-center justify-center p-4 bg-white rounded shadow">
        @foreach($cart as $item)
        <div class="flex items-center flex-row gap-2 w-full">
            <img src="{{ $item['image_url']  }}" class="h-60 w-40 object-cover rounded">
            <div class="ml-4">
                <h3 class="font-semibold">{{ $item['name'] }}</h3>
                <p class="text-lg font-bold">${{ number_format($item['price'],2) }} Each</p>
               
                    <div class="flex py-2 items-center content-center gap-2">

                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center m-0 ">
                            @csrf
                            <input type="hidden" name="quantity" value="{{ $item['quantity']+1 }}">
                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                            <button type="submit" class="py-1 px-2 bg-green-600 self-center text-white rounded">+</button>
                        </form>
                        <p type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 p-1 border rounded">{{ $item['quantity'] }}</p>
                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center  m-0">
                            @csrf
                            <input type="hidden" name="quantity" value="{{ $item['quantity']-1 }}">
                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                            <button type="submit" class="py-1 px-2 bg-red-600 text-white rounded">-</button>
                        </form>
                    </div>
            
                
            </div>
        </div>
        <hr class="my-4 bg-gray-300">
        @endforeach
        <form action="{{route('checkout.store')}}" method="POST" class="flex flex-col items-center gap-4">
            @csrf
            <input type="text" name="full_name" placeholder="Name" class="w-[40%] p-2 border rounded mb-4 required-true" >
            <input type="text" name="address" placeholder="Address" class="w-[40%] p-2 border rounded mb-4" required>
            <input type="text" name="phone" placeholder="Phone" class="w-[40%] p-2 border rounded mb-4"required>
            <button type="submit" class="mt-4 w-[40%] py-2 bg-blue-600 text-white rounded">Place Order</button>
        </form>
    </div>
    <div class="flex-2 p-4 bg-white rounded shadow ml-8 h-30">
        <h2 class="text-2xl font-bold mb-4">Cart Summary</h2>
        <p class="text-lg">Total Price: ${{ number_format($total,2) }}</p>
    </div>
</div>
@endsection
