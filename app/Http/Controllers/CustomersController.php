<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\CreateCustomerRequest;
class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customers.index')->with('customers',Customer::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCustomerRequest $request)
    {
        Customer::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
        ]);

        session()->flash('success','Customer Created Successfully');

        return redirect(route('customers.index'));    
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if(empty($customer->orders)){
            $customer->delete();
            session()->flash('success','Customer Deleted Successfully');
            }
            else{
                session()->flash('fail','Customer has Orders');
    
            }
            return redirect(route('customers.index'));
    }
}
