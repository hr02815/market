<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;

use App\Models\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index')->with('products',Product::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        Product::create([
            'name'=> $request->name,
            'description'=> $request->description,
            'cost_price'=> $request->costPrice,
            'selling_price'=> $request->sellingPrice,
            'tax'=> $request->tax


        ]);

        session()->flash('success','Product Created Successfully');

        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.create')->with('product',$product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'cost_price' => $request->costPrice,
            'selling_price' => $request->sellingPrice,
            'tax' => $request->tax

            

        ]);
        
        session()->flash('success','Product updated successfully');

        return redirect(route('products.index'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if(empty($product->orderlines)){
        $product->delete();
        session()->flash('success','Product Deleted Successfully');
        }
        else{
            session()->flash('fail','Product has Orders');

        }
        return redirect(route('products.index'));
    }
}
