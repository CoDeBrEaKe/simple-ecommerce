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
use App\Services\ImageKitService;


class ProductController extends Controller{

    protected $imageKit;
     public function __construct(ImageKitService $imageKit)
    {
        $this->imageKit = $imageKit;
    }

    public function logAction($action , $productName,$details){
        ProductLog::create([
            'action'=>$action,
            'product_name'=>$productName,
            'details'=>$details
        ]);
    }

    public function dashboardIndex(){
        $query = Product::query();
        $products = $query->paginate(10);
        return view('dashboard.products', compact('products'));
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

    public function edit(Product $product)
    {
    return view('products.edit', compact('product'));
    }

    public function show(Product $product )
    {
        return redirect()->route('products.index');
    }
    public function createProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'stock'       => 'required|numeric',
            'price'       => 'required|numeric',
            'image_url'       => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = fopen($request->file('image')->getPathname(), "r");
            $fileName = $request->file('image')->getClientOriginalName();

            $upload = $this->imageKit->upload($file, $fileName);

            $imageUrl = $upload->result->url;
        }
        $this->logAction('create',$name,'Product created with price: '.$price.' and stock: '.$stock);
        return redirect()->route('admin.productsIndex')->with('success', 'Product created successfully');
    }
  
    public function updateProduct(Product $product)
    {
        if ($request->hasFile('image')) {
            $file = fopen($request->file('image')->getPathname(), "r");
            $fileName = $request->file('image')->getClientOriginalName();

            $upload = $this->imageKit->upload($file, $fileName);

            $imageUrl = $upload->result->url;
        }
        $oldProduct = Product::find($product->id);
        $updates = [];
        if ($oldProduct->name !== $product->name) { $updates['name'] = $name; }
        if ($oldProduct->price !== $product->price) { $updates['price'] = $price; }
        if ($oldProduct->stock !== $product->stock) { $updates['stock'] = $stock; }
        if ($oldProduct->image !== $product->image) { $updates['image_url'] = $image; }

        if (!empty($updates)) {
            $product->update($updates);
            $this->logAction('update',$originalName,'Product updated: '.json_encode($updates));
        }

        return redirect()->route('admin.productsIndex')->with('success', 'Product updated successfully');
    }
    public function delete(Product $product)
    {
        $productName = $product->name;
        $product->delete();
        $this->logAction('delete',$productName,'Product deleted');
        return redirect()->route('admin.productsIndex')->with('success', 'Product deleted successfully');
    }
}
