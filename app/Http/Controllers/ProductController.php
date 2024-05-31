<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $products = Product::query()
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->orWhere('init_price', 'like', "%{$search}%")
            ->orWhere('qte', 'like', "%{$search}%")
            ->orWhere('selling_price','like',"%{$search}%");
        })
        ->paginate(10);

        return Inertia::render('Products/Index', [
            'products' => $products, 
            'search' => $search
        ]);

    }

    public function restore(){
        $restoreProducts = Product::onlyTrashed()->paginate(10); // Utilisation de paginate pour la pagination
        return Inertia::render('Products/Restore', [
            'restoreProducts' => $restoreProducts
        ]);
    
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'selling_price' => 'required|numeric',
            'init_price' => 'required|numeric',
            'description' => 'string',
            
        ]);
    
        $productData = $request->all();
        $profit = $productData['selling_price'] - $productData['init_price'];
        $productData['profit'] = $profit;
        $product = new Product($productData);
        $product->save();
    
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        return Inertia::render('Products/Show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return Inertia::render('Products/Edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
                
        $request->validate([
            'name' => 'string',
            'selling_price' => 'numeric',
            'init_price' => 'numeric',
            'description' => 'string',
        ]);

        $productData = $request->all();
        $profit = $productData['selling_price'] - $productData['init_price'];
        $productData['profit'] = $profit;
        $product = Product::find($id);
        $product->update($productData);
        return redirect()->route('products.index')->with('success', 'Product updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('products.index');
        }
        
        $product->delete();
        return redirect()->route('products.index');
    
    }
    


    public function productRestore($id){
        
        $restoreProduct = Product::onlyTrashed()->orderBy('deleted_at','asc')->findOrFail($id);
        $restoreProduct->restore();
        return redirect()->route('products.index');
    }


}
