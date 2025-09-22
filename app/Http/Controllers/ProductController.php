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
use ImageKit\ImageKit;



class ProductController extends Controller{


    public function __construct()
    {
        $this->imageKit = new ImageKit(
            env('IMAGEKIT_PUBLIC'),
            env('IMAGEKIT_PRIVATE'),
            "https://ik.imagekit.io/mohstorage"
        );
    }

    public function logAction($action , $productId ,$details){
        ProductLog::create([
            'action'=>$action,
            'product_id'=>$productId,
            'changed_by'=>Auth::id(),
            'details'=>$details
        ]);
    }

    public function dashboardIndex(Request $request){
        $query = Product::query();
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('name','like',"%{$q}%");
        }
        
        $products = $query->paginate(10);
        return view('dashboard.products', compact('products'));
    }
    
    public function index(Request $request)
    {

        $cart = session()->get('cart', []);
        $query = Product::query();
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('name','like',"%{$q}%");
        }
        
        $products = $query->paginate(12);
        session()->put('cart', $cart);
        return view('products.index', compact('products'));
    }

    public function create()
    {
    return view('products.create');
    }
    public function edit(Product $product)
    {
    return view('products.edit', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'stock'       => 'required|numeric',
            'price'       => 'required|numeric',
            'image_url'       => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $file = fopen($request->file('image_url')->getPathname(), "r");
            $fileName = $request->file('image_url')->getClientOriginalName();

            $upload = $this->imageKit->upload([
                'file' => $file, 
                'fileName' => $fileName,
            ]);
                $imageUrl = $upload->result->url;
            $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_url'=>$imageUrl
        ]);  
        }

       
        $this->logAction('create',$product->id,'Product created with price: '.$request->price.' and stock: '.$request->stock);
        return redirect()->route('admin.productsIndex')->with('success', 'Product Added successfully');
    }
  
    public function update(Product $product , Request $request)
    {
        $imageUrl = $product->image_url;
         if ($request->hasFile('image_url')) {
            $file = fopen($request->file('image_url')->getPathname(), "r");
            $fileName = $request->file('image_url')->getClientOriginalName();

            $upload = $this->imageKit->upload([
                'file' => $file, 
                'fileName' => $fileName,
            ]);
                $imageUrl = $upload->result->url;
            }
            
                 $updates = [];
                 if ($request->name !== $product->name) { $updates['name'] =$request->name ; }
                 if ($request->price !== $product->price) { $updates['price'] = $request->price; }
                 if ($request->stock !== $product->stock) { $updates['stock'] = $request->stock; }
                 if ($imageUrl !== $product->image_url) { $updates['image_url'] = $imageUrl; }
         
                     $product->update($updates);
                     $product->save();
                     $this->logAction('update',$product->id,'Product'.$product->id.'updated: '.json_encode($updates));

        return redirect()->route('admin.productsIndex')->with('success', 'Product updated successfully');
    }
    public function delete(Product $product)
    {
        $productId = $product->id;
        $product->delete();
        $this->logAction('delete',$productId,'Product deleted');
        return redirect()->route('admin.productsIndex')->with('success', 'Product deleted successfully');
    }
}
