@extends('layouts.app')

@section('content')
<div class="flex" >

<x-aside activePage="orders" />
<div class="container mx-auto py-8  w-full">
        <div class="w-full px-4">
            <h2 class="text-2xl font-semibold mb-4">Orders</h2>
            <table class="w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-start border-b border-gray-200">ID</th>
                        <th class="py-2 px-4 text-start border-b border-gray-200">Full Name</th>
                        <th class="py-2 px-4 text-start border-b border-gray-200">Total Price</th>
                        <th class="py-2 px-4 text-start border-b border-gray-200">Date</th>
                        <th class="py-2 px-4 text-start border-b border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $order->id }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $order->full_name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">${{ $order->total_price }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $order->created_at }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">
                            
                            <a href="{{ route('admin.show' , $order) }}" class="text-blue-500 hover:underline block">Details</a>
                            <form action="{{ route('admin.deleteOrder', $order) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline " onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>

    </div>
@endsection