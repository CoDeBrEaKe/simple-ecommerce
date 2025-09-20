<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\ProductLog;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller{
    public function logAction($action , $productName,$details){
        ProductLog::create([
            'action'=>$action,
            'product_name'=>$productName,
            'details'=>$details
        ]);
    }


    public function index(Request $request)
    {
        $query = Product::query();

        // if ($request->filled('q')) {
        //     $q = $request->q;
        //     $query->where('name','like',"%{$q}%")
        //           ->orWhere('description','like',"%{$q}%");
        // }
        $products = $query->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(Product $product , $action = 'show')
    {
        if($action == 'show'){
            return redirect()->route('products.index');
        }else if ($action == 'edit'){
            return view('products.edit', compact('product'));
        }
    }
    public function createProduct($name , $price, $stock, $description = null, $image = null)
    {
        $product = Product::create([
            'name' => $name,
            'price' => $price,
            'stock' => $stock,
            'image_url' => $image
        ]);
        $this->logAction('create',$name,'Product created with price: '.$price.' and stock: '.$stock);
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }
  
    public function updateProduct(Product $product, $name = null, $price = null, $stock = null, $description = null, $image = null)
    {
        $originalName = $product->name;
        $updates = [];
        if ($name !== $product->name) { $updates['name'] = $name; }
        if ($price !== $product->price) { $updates['price'] = $price; }
        if ($stock !== $product->stock) { $updates['stock'] = $stock; }
        if ($image !== $product->image) { $updates['image_url'] = $image; }

        if (!empty($updates)) {
            $product->update($updates);
            $this->logAction('update',$originalName,'Product updated: '.json_encode($updates));
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }
    public function deleteProduct(Product $product)
    {
        $productName = $product->name;
        $product->delete();
        $this->logAction('delete',$productName,'Product deleted');
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
