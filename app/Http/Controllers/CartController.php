<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Product;

class CartController extends Controller
{
    protected function getCart() {
        return session()->get('cart', []);
    }

    public function index()
    {
        $cart = $this->getCart();
        // compute total
        $total = collect($cart)->reduce(fn($t,$item) => $t + $item['price'] * $item['quantity'], 0);
        return view('cart.index', compact('cart','total'));
    }

    public function add(Request $request, Product $product)
    {

        $qty = (int)$request->input('quantity',1) || 1;

        $cart = $this->getCart();

        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float)$product->price,
                'quantity' => $qty,
                'image_url' => $product->image,
            ];
        }
        session()->put('cart', $cart);
        return back()->with('success','Product added to cart');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $qty = (int)$request->input('quantity');
        $cart = $this->getCart();
        if(isset($cart[$id])){
            if ($qty == 0){
                unset($cart[$id]); 
                session()->put('cart', $cart);
            }else{
                $cart[$id]['quantity'] =  $qty;
                session()->put('cart', $cart);
            }
        }
        return back();
    }
}
