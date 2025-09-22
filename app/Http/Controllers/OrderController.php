<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller{

    public function dashboardIndex(Request $request){
        $orders = Order::query()->orderBy('created_at','desc')->paginate(20);
        return view('dashboard.orders', compact('orders'));
    }

public function deleteOrder(Order $order){

    DB::beginTransaction();
    try{
        $takenProducts = OrderProduct::where('order_id',$order->id);
        foreach($takenProducts as $item){
            $product = Product::find($item->product_id);
            if($product){
                $product->stock = $product->stock + $item->quantity;
                $product->save();
            }
        }
        $order->delete();
        DB::commit();   

        return redirect()->route('admin.orderIndex')->with('success', 'Order updated successfully');

    } catch(\Throwable $e){
        DB::rollBack();
        return back()->with('error' , "Something went wrong: ".$e->getMessage());
    }
}

public function show(Order $order){
    
    $items = $order->products;
    $total = $items->sum('price');
    return view('dashboard.items' ,compact('items' , 'total'));
}

}