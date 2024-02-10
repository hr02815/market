@extends('layouts.app')

@section('content')

<div class="card card-default">
    <div class="card-header">
        {{isset($order) ? 'Edit Order' : 'Add Order'}}
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
        <form id="orderForm" action="{{isset($order) ? route('orders.update',$order->id) : route('orders.store')}}" method = "POST">
            @csrf
            @if(isset($order))
                @method('PUT')
            @endif
            
            

            <div class="form-group">
            <label for="customer">Customer</label>
                <select name="customerId" id="customer" class="form-control">
                    @foreach($customers as $customer)
                        <option id="{{$customer->id}}" value="{{$customer->id}}">
                            {{$customer->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="external_order_id">External Order Number</label>
                <input type="text" id="external_order_id" class="form-control" name="external_order_id" value = "{{isset($order) ? $order->external_order_id : ''}}" {{isset($order) ? "readonly" : ""}}>
            </div>
            <br>
            <div class="form-group">
                
                <button type="button" class="btn btn-success" onclick="add_product()">
                    Add Product
                </button>
                

            <!-- <button type="button" class="btn btn-success col-md-2" onclick="add_product()">
            Add Product
            </button> -->

            </div>

            <div class="form-group mt-2" id="products">
                <div class="card" id = "card">
                    <div class="card-body">
                        @if(isset($orderProducts))
                            {{\Log::info($orderProducts)}}
                            @for($i = 1; $i <= count($orderProducts); $i++)
                                <label for="{{'product'.($i)}}">{{'Product '.$i}}</label>
                                <select name="product[]" id="{{'product'.$i}}" class="form-control">
                                @foreach($products as $product)
                                    <option id="{{'product'.$i.$product->id}}" value="{{$product->id}}" data-price="{{$product->selling_price}}" data-tax="{{$product->tax}}"
                                    @if($product->id == $orderProducts[$i-1]->product_id)
                                        selected
                                    @endif
                                    >
                                        {{$product->name}}
                                    </option>
                                @endforeach
                            
                            </select>
                            <label for="{{'product'.$i.'Quantity'}}">Quantity</label>
                            {{\Log::info($orderProducts[$i-1])}}
                            <input type="number" id="{{'product'.$i.'Quantity'}}" class="form-control" name="quantity[]" value = "{{$orderProducts[$i-1]->quantity}}">
                            @endfor
                        
                        @else
                            {{\Log::info("in else block")}}
                            <label for="product1">Product 1</label>
                                <select name="product[]" id="product1" class="form-control">
                                @foreach($products as $product)    
                                <option id="product1{{$product->id}}" value="{{$product->id}}" data-price="{{$product->selling_price}}" data-tax="{{$product->tax}}">
                                        {{$product->name}}
                                </option>
                                @endforeach
                            
                            </select>
                            <label for="product1Quantity">Quantity</label>
                            <input type="number" id="product1Quantity" class="form-control" name="quantity[]" value="0">
                        @endif
                        <br>
                        <button type="button" id="product1Delete" class="btn btn-success btn-sm" onclick="remove_product(this)">
                            Remove Product
                        </button>
                    </div>
                    <p>---------------------------------------------------------------------------------------------</p>

                </div>
            </div>
            
            <div class="form-group" id = "info">
                <label for="totalItems">Total Items</label>
                <input type="number" id="totalItems" class="form-control" name="totalItems" value = "{{isset($order) ? $order->total_items : '1'}}" readonly>
                
                <label for="totalAmount">Total Amount</label>
                <input type="number" id="totalAmount" class="form-control" name="totalAmount" value = "{{isset($order) ? $order->total_amount : 0}}" readonly>
            </div>
            <br>
            <div class="form-group">

                <button class="btn btn-success" >
                    Place Order
                </button>

            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    console.log("here");
    console.log("in order");
    //document.getElementById("totalAmount").value = 0;
    const selectedProducts = [];
    const selectedQuantities = [];

    //const add_product = () =>{
    document.addEventListener('DOMContentLoaded', function() {   
        var formQuantity = document.getElementsByName("quantity[]");
        var formProduct = document.getElementsByName("product[]");
        //console.log("product value:"+formProduct[0].value);
        for (let i = 0; i < formProduct.length; i++) {
            console.log("in loop");
            console.log("product1 value:"+formProduct[i].value)
                selectedProducts.push(formProduct[i].value);
                selectedQuantities.push(formQuantity[i].value);
                console.log("selectedProducts"+i+":"+selectedProducts[0]);
            } 
        for(let i = 0; i < selectedProducts.length; i++){
            console.log("in selcted products");
            console.log(i+":"+selectedProducts[i]);
        }
        document.getElementById("orderForm").addEventListener("submit", function (e) {
            e.preventDefault();
            var container= document.getElementsByClassName('alert alert-danger');
            for (let i = 0; i < container.length; i++) {
                container[i].remove();
            } 

            container = document.getElementsByClassName('card-body');
            var div = document.createElement("div");
            div.setAttribute("class","alert alert-danger");
            var ul = document.createElement("ul");
            ul.setAttribute("class","list-group");
            container[0].insertBefore(div, container[0].firstChild);
            var li = document.createElement('li');
            li.setAttribute("class","list-group-item text-danger");
            div.appendChild(ul);
            ul.appendChild(li);
            console.log("in here submit");
            /*
            if(document.getElementById("external_order_id").value == ''){
                console.log("in external order num");
            //document.getElementById("errors").style.display = "block";
            li.innerHTML = "External order number not enetered";
            return false;
        }*/
            let form = document.getElementsByName('product[]');
            const w = new Set();
            for (let i = 0; i < form.length; i++) {
                console.log(w);
                console.log(form[i].value);

                if(w.has(form[i].value)){
                        //console.log("in heree");
                        //e.preventDefault();
                        //document.getElementById("errors").style.display = "block";

                        li.innerHTML = "Atleast two same products selected";
                        return false;
                }
                else{
                    w.add(form[i].value);
                }
            } 
            let productQuantity = document.getElementsByName('quantity[]');

            for (let i = 0; i < form.length; i++) {
                if(productQuantity[i].value < 1){

                    //document.getElementById("errors").style.display = "block";

                    li.innerHTML = "Product Quantity not entered";
                    return false;
                }
            }

            document.getElementById("orderForm").submit();
    });
        //document.getElementById("errors").style.display = "none";

        //document.getElementById("totalItems").value = 1;
        
        document.getElementById("product1").addEventListener("change",function (e){
            console.log("in product1");
            update_amount(e);
        });
        document.getElementById("product1Quantity").addEventListener("change",function (e){
            update_amount(e);
        });

        //selectedProducts.push(document.getElementById("product1").value);
        //selectedQuantities.push(document.getElementById("product1Quantity").value);
        //let a = document.getElementById("product1");
        //let b = a.selectedIndex;
        //console.log(a.value);

        //console.log(b.value);

        }, false);
    
        //document.getElementById("info").innerHTML = oldProductId + "<br>" + newProductId; 
        
    //const formInputs = document.getElementsByClassName("form-control");     
        
        console.log("before event handler");

    
    /*
    formInputs.addEventListener("change", (event) => {
        console.log("here");
        const formTotalAmount = document.getElementById("totalAmount"); 
        let totalAmount = 0;
        let orderLine;
        let selectedProduct;
        let selectedQuantity;
        for(let i = 0; i < formTotalItems.value; i++){
            orderLine = document.getElementById(("product" + i));
            selectedProduct = orderLine.options[orderLine.selectedIndex];
            selectedQuantity = document.getElementById(("product" + i + "Quantity"));
            totalAmount = totalAmount + (selectedProduct.data-price * ((selectedProduct.data-tax + 100)/100)) * selectedQuantity;
        }
        formTotalAmount.value = totalAmount;
});
    */
   function update_amount(){
    let formTotalItems = document.getElementById("totalItems");
    let a = document.getElementById("product1");
    //console.log(a.value);
    //document.getElementByID
    console.log("here1");
        let targetElement = event.target;
        let elementId = targetElement.id;
        if(targetElement.id[elementId.length -1] == "y"){
            console.log("here2");
            let indexOfQ = elementId.indexOf["Q"];
            let productNum = parseInt(elementId.slice(7,indexOfQ));
            console.log(productNum);
            selectedQuantities[productNum - 1] = targetElement.value;  
        }
        else{
            console.log("here3");

            let productNum = parseInt(elementId.slice(7));
            console.log(productNum);
            selectedProducts[productNum-1] = targetElement.value;
        }
        
        // console.log(formTotalItems);
        let formTotalAmount = document.getElementById("totalAmount"); 
        let totalAmount = 0;
        let orderLine;
        let selectedProduct;
        let selectedQuantity;
        for(let i = 1; i <=parseInt(formTotalItems.value); i++){
            orderLine = document.getElementById(("product" + i));
            //console.log(orderLine);
            selectedProduct = orderLine.options[orderLine.selectedIndex];
            //console.log(selectedProduct);
            selectedQuantity = parseInt(document.getElementById(("product" + i + "Quantity")).value);
            //console.log(selectedQuantity);
            //console.log(selectedProduct.price);
            let a = ((parseInt(selectedProduct.getAttribute("data-tax")) + 100)/100)
            let b = parseInt(selectedProduct.getAttribute("data-price"));
            
            //console.log(a);
            //console.log(b);
            let c = a*b;
            //console.log(c);

            let d = c*selectedQuantity;
            totalAmount = totalAmount + d;
            //totalAmount = totalAmount + selectedProduct.price * ((selectedProduct.tax + 100)/100) * selectedQuantity;
            //console.log(totalAmount);
        }
        formTotalAmount.value = totalAmount;
         
   }
    
   
        
    
        let pattern;
        let productCount = 1;
        let product = document.getElementById("products").innerHTML;
        let oldProductId = "product" + productCount;
        let newProductId = "product" + (productCount +1);
        //let productNum = "Product 1";
    //document.getElementById("test").innerHTML = product;
    function add_product(){
        let formTotalItems = document.getElementById("totalItems");
        
        
        //document.getElementById("product1").addEventListener("change",update_amount);
        //document.getElementById("product1Quantity").addEventListener("change",update_amount);
    
        pattern = new RegExp(oldProductId, "g");
        product = product.replace(pattern, newProductId);

        productCount++;

        pattern  = new RegExp(("Product " + (productCount -1)), "g");
        product = product.replace(pattern, ("Product " + (productCount)));
        console.log(product);

        oldProductId = newProductId;
        newProductId = "product" + (productCount + 1);
        //document.getElementById("info").innerHTML = document.getElementById("info").innerHTML + oldProductId + "<br>" + newProductId + "<br>";
        form = document.getElementById("products");
        form.innerHTML = form.innerHTML +product;

        for (let i = 1; i <= formTotalItems.value; i++) {
                console.log("selectedProducts"+i+":"+selectedProducts[i-1]);
                console.log(selectedQuantities[i-1]);
                document.getElementById(("product"+i)).value = selectedProducts[i-1];
                document.getElementById(("product"+i+"Quantity")).value = selectedQuantities[i-1];
            }
            selectedProducts.push(1);
            selectedQuantities.push(0);

        document.getElementById(("product"+productCount)).addEventListener("change",function (e){
            update_amount(e);
        });
        document.getElementById(("product"+productCount+"Quantity")).addEventListener("change",function (e){
            update_amount(e);
        });
        formTotalItems.value++; 

    }
    function remove_product(_this){

        let totalItems = document.getElementById("totalItems");
        if(totalItems.value <= 1)
            {
            console.log("return");
                return;
            }
        //console.log(_this.previousElementSibling.previousElementSibling.tagName);
        //return;
        console.log(_this.id);
        let indexOfD = _this.id.indexOf["Delete"];
        let productNum = parseInt(_this.id.slice(7,indexOfD));
        console.log(productNum);
        //let productNum = parseInt(_this.id.slice(7));
        let productQuantity = document.getElementById("product"+productNum+"Quantity");
        productQuantity.value = 0;
        const event = new Event("change");
        document.getElementById(("product"+productNum+"Quantity")).dispatchEvent(event);

        let parent = productQuantity.parentElement.parentElement.parentElement;
        productQuantity.parentElement.parentElement.remove();
        selectedProducts.splice(productNum-1,1);
        selectedQuantities.splice(productNum-1,1);
        
        for (let i = 0; i < (parent.children.length); i++) {

            console.log("Parent children length:"+parent.children.length);
            let productElements = parent.children[i].children[0].children;
            productElements[1].id = "product"+(i+1);
            productElements[0].htmlFor = "product"+(i+1);
            productElements[0].innerHTML = "Product "+(i+1);
            productElements[2].htmlFor = "product"+(i+1)+"Quantity";
            productElements[3].id = "product"+(i+1)+"Quantity";
            productElements[5].id = "product"+(i+1)+"Delete";

            /*
            document.getElementById("product"+(productNum+1+i)).id = "product"+(productNum+i);
            document.getElementById("product"+(productNum+i)).previousElementSibling.htmlFor = "product"+(productNum+i);
            document.getElementById("product"+(productNum+i)).previousElementSibling.innerHTML = "Product " + (productNum+i);
            document.getElementById("product"+(productNum+i)).nextElementSibling.htmlFor = "product"+(productNum+i)+"Quantity";
            document.getElementById("product"+(productNum+i)).nextElementSibling.nextElementSibling.id = "product"+(productNum+i)+"Quantity";

            */
        }

        let form = document.getElementById("products");
        
        //form.lastElementChild.value = 0;
        
        

        //ev.initInputEvent("change", true, true);

       
    pattern = new RegExp(("product"+(totalItems.value)), "g");
    product = product.replace(pattern, ("product" + (productCount -1)));
    oldProductId = "product"+(totalItems.value -1);
    newProductId = "product"+(totalItems.value);
    pattern  = new RegExp(("Product " + (productCount)), "g");
    product = product.replace(pattern, ("Product " + (productCount -1)));

    console.log(product);

    /*
    document.getElementById(("product"+totalItems.value)).removeEventListener("change",function (e){
            update_amount(e);
        });
    document.getElementById(("product"+totalItems.value+"Quantity")).removeEventListener("change",function (e){
            update_amount(e);
    });
    /*
if(form.lastElementChild.tagName == "BR")
{
    console.log("in tagname");
    form.removeChild(form.lastElementChild);
}
    for (let i = 0; i < 4; i++) {
        
        form.removeChild(form.lastElementChild);        
    }
    if(form.lastElementChild.tagName == "BR")
{
    console.log("in tagname");
    form.removeChild(form.lastElementChild);
}
*/
productCount--;
totalItems.value--;
console.log("total items:"+totalItems.value);

    

    //selectedProducts.pop();
    //selectedQuantities.pop();
}
</script>
@endsection