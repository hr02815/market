<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\order_product;
use App\Http\Requests\CreateOrderRequest;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd(Order::first()->customer->name);
        return view('orders.index')->with('orders',Order::all());

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orders.create')->with('products',Product::all())->with('customers',Customer::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        //dd(request()->all());
        $totalQuantity = 0;
        foreach ($request->quantity as $value) {
            $totalQuantity += $value;
          }        
        $order = Order::create([
            'customerId'=> $request->customerId,
            'user_id'=> \Auth::id(),
            'external_order_id'=>$request->external_order_id,
            'total_amount'=> $request->totalAmount,
            'total_items'=> $request->totalItems,
            'total_quantity'=> $totalQuantity
    
        ]);

        
        for ($i = 0; $i < $request->totalItems; $i++) {
            order_product::create([
                'order_id'=> $order->id,
                'product_id'=>$request->product[$i],
                'quantity'=> $request->quantity[$i]
        
            ]);
          } 
        
        session()->flash('success','Order Created Successfully');

        return redirect(route('orders.index'));
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
    public function edit(Order $order)
    {
        //dd($order->orderlines);
        $orderProducts = $order->orderLines;
        return view('orders.create')->with('order',$order)->with('products',Product::all())->with('orderProducts',$orderProducts)->with('customers',Customer::all());

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update([
            'customerId'=> $request->customerId,
            'user_id'=> \Auth::id(),
            'external_order_id'=>$request->external_order_id,
            'total_amount'=> $request->totalAmount,
            'total_items'=> $request->totalItems,
            'total_quantity'=> $totalQuantity
        ]);
        $orderLines = $order->orderLines;

        for ($i = 0; $i < count($orderLines); $i++) {
            $orderLines[i]->delete();
          } 
          for ($i = 0; $i < count($request->totalItems); $i++) {
            order_product::create([
                'order_id'=> $order->id,
                'product_id'=>$request->product[$i],
                'quantity'=> $request->quantity[$i]
        
            ]);
          }
          session()->flash('success','Order Updated Successfully');

        return redirect(route('orders.index')); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $orderLines = $order->orderLines;
        for ($i = 0; $i < count($orderLines); $i++) {
            $orderLines[$i]->delete();
          } 
        $order->delete();
        session()->flash('success','Order Deleted Successfully');
        return redirect(route('orders.index'));
    }
    
}
