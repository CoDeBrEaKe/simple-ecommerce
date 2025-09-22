@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8  w-full ">
        <div class="w-full px-4 flex flex-col gap-4">
            <h2 class="text-2xl font-semibold mb-4">Products</h2>

            <table class="w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-start border-b border-gray-200">ID</th>
                        <th class="py-2 px-4 text-start border-b border-gray-200">Quantity</th>
                        <th class="py-2 px-4 text-start border-b border-gray-200">Price</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($items as $product)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $product->id }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $product->quantity }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">${{ $product->price }}</td>
                    
                    </tr>
                    @endforeach
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200"></td>
                        <td class="py-2 px-4 border-b border-gray-200">Total</td>
                        <td class="py-2 px-4 border-b border-gray-200">${{ $total }}</td>
                    
                    </tr>
                </tbody>
            </table>
     
        </div>

    </div>
@endsection