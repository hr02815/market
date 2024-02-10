@extends('layouts.app');

@section('content')

<div class="card card-default">
    <div class="card-header">
        {{isset($product) ? 'Edit Product' : 'Create Product'}}
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="list-group">
                    @foreach($errors->all() as $error)
                        <li class="list-group-item text-danger">
                            {{$error}}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{isset($product) ? route('products.update',$product->id) : route('products.store')}}" method = "POST">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" name="name" value = "{{isset($product) ? $product->name : ''}}" >
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" id="description" class="form-control" name="description" value = "{{isset($product) ? $product->description : ''}}">
            </div>
            <div class="form-group">
                <label for="costPrice">Cost Price</label>
                <input type="number" id="costPrice" class="form-control mb-2" name="costPrice" value = "{{isset($product) ? $product->cost_price : ''}}">
            </div>
            <div class="form-group">
                <label for="sellingPrice">Selling Price</label>
                <input type="number" id="sellingPrice" class="form-control mb-2" name="sellingPrice" value = "{{isset($product) ? $product->selling_price : ''}}">
            </div>
            <div class="form-group">
                <label for="tax">Tax</label>
                <input type="number" id="tax" class="form-control mb-2" name="tax" value = "{{isset($product) ? $product->tax : ''}}">
            </div>
            
            <div class="form-group">
                <button class="btn btn-success">{{isset($product) ? 'Update Product' : 'Add Product'}}</button>
            </div>
        </form>
    </div>
</div>
@endsection