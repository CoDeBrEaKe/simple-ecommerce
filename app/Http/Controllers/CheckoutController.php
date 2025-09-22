<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) 
            return redirect()->route('home')->with('info','Cart is empty');

        $total = collect($cart)->reduce(fn($t,$i)=> $t + $i['price']*$i['quantity'], 0);
        return view('checkout.index', compact('cart','total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if(empty($cart)) return back()->with('error','Cart is empty');

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
                // optionally decrement stock:
                $product = Product::find($item['id']);
                if($product){
                    $product->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('home')->with('success','Order placed successfully');
        } catch(\Throwable $e) {
            DB::rollBack();
            return back()->with('error','Something went wrong: '.$e->getMessage());
        }
    }
}
