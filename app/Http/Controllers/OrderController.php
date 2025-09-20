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
class OrderController extends Controller{

    public function dashboardIndex(Request $request){
        $orders = Order::query()->orderBy('created_at','desc')->paginate(20);
        return view('dashboard.orders', compact('orders'));
    }

    public function createOrder(Request $request){
          DB::beginTransaction();
        try {
            $total = collect($cart)->reduce(fn($t,$i)=> $t + $i['price']*$i['quantity'], 0);

            $order = Order::create([
                'full_name' => $request->input('full_name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'total_price' => $total,
                
            ]);

            foreach($cart as $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
                //  Decrementing stock after the order:
                $product = Product::find($item['id']);
                if($product){
                    $product->stock = $product->stock - $item['quantity'];
                    // ('stock', $item['quantity']);
                }
            }
            DB::commit();   
    }
    catch(\Throwable $e) {
            DB::rollBack();
            return back()->with('error','Something went wrong: '.$e->getMessage());
    }
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
    } catch(\Throwable $e){
        DB::rollBack();
        return back()->with('error' , "Something went wrong: ".$e->getMessage());
    }
}

}