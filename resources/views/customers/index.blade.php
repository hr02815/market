@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-end mb-2">
    <a href="{{route('customers.create')}}" class="btn btn-success">Create customer</a>
</div>
<div class="card card-default">
    <div class="card-header">
        Customers
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <th>
                    ID
                </th>
                <th>
                    Name
                </th>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>
                            {{$customer->id}}
                        </td>
                        <td>
                            {{$customer->name}}
                        </td>
                        <td>
                            <a href="{{route('customers.edit',$customer->id)}}" class="btn btn-info btn-sm">edit</a>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="handle_delete({{$customer->id}})">delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="" method="POST" id="deleteCustomerForm">
        @csrf
        @method('DELETE')
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Customer</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-center text-bold">
        Are you sure you want to delete this Customer?
        </p>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Go back</button>
        <button type="submit" class="btn btn-danger">Yes, Delete</button>
      </div>
    </div>

    </form>
    
  </div>
</div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function handle_delete(id){
        console.log('deleting',id)
        $('#deleteModal').modal('show')
        var form = document.getElementById('deleteCustomerForm')
        form.action = '/customers/' + id

    }
</script>
@endsection