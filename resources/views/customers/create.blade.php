@extends('layouts.app');

@section('content')

<div class="card card-default">
    <div class="card-header">
        {{isset($customer) ? 'Edit Customer Details' : 'Add Customer'}}
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
        <form action="{{isset($customer) ? route('customers.update',$customer->id) : route('customers.store')}}" method = "POST">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" name="name" value = "{{isset($customer) ? $customer->name : ''}}" >
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" name="email" value = "{{isset($customer) ? $customer->email : ''}}">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" class="form-control mb-2" name="phone" value = "{{isset($customer) ? $customer->phone : ''}}">
            </div>
            
            <div class="form-group">
                <button class="btn btn-success">Add Customer</button>
            </div>
        </form>
    </div>
</div>
@endsection