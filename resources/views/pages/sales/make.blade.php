<x-app-layout>
    <style>
        .small-xs{
            font-size: 85%;
            font-weight: 400;
        }
    </style>
<div id="app">
    
    {{-- <ul id="example-1">

        <li v-for="item in products" :key="item.productName">
            @{{ item }}
        </li>
      </ul> --}}
    <div class="container">
        <div class="card-deck my-4">
            <div class="card">
               <div class="card-header">Number Of Stocks</div>
               <div class="card-body">
                    <div class="media mb-3">
                        <img src="{{ asset('images/brolier_chicken.jpg') }}" class="mr-3 w-25" alt="...">
                        <div class="media-body">
                            <h6 class="mt-0">Brolier Chicken</h6>
                            130 KG
                        </div>
                    </div>
                    <div class="media mb-3">
                        <img src="{{ asset('images/brolier_chicken.jpg') }}" class="mr-3 w-25" alt="...">
                        <div class="media-body">
                            <h6 class="mt-0">Layer</h6>
                            10 KG
                        </div>
                    </div>
                    <div class="media">
                        <img src="{{ asset('images/brolier_chicken.jpg') }}" class="mr-3 w-25" alt="...">
                        <div class="media-body">
                            <h6 class="mt-0">Brolier Egg</h6>
                            130 
                        </div>
                    </div>
               </div>
            </div>
            <div class="card">
                <div class="card-header">Stocks Request</div>
                <div class="card-body">
                    <div class="media mb-3">
                        <img src="{{ asset('images/brolier_chicken.jpg') }}" class="mr-3 w-25" alt="...">
                        <div class="media-body">
                            <h6 class="mt-0">Broiler Chicken</h6>
                            <form action="#" method="POST" class="d-flex">
                                <input class="form-control form-control-sm w-50" name="broiler_chicken" value="10 KG" />
                                <input  type="submit" value="Rquest" class="btn btn-warning btn-sm ml-2" />
                            </form>
                        </div>
                    </div>
                    <div class="media mb-3">
                        <img src="{{ asset('images/brolier_chicken.jpg') }}" class="mr-3 w-25" alt="...">
                        <div class="media-body">
                            <h6 class="mt-0">Layer</h6>
                            <form action="#" method="POST" class="d-flex">
                                <input class="form-control form-control-sm w-50" name="layer" value="10 KG" />
                                <input  type="submit" value="Rquest" class="btn btn-warning btn-sm ml-2" />
                            </form>
                        </div>
                    </div>
                    <div class="media">
                        <img src="{{ asset('images/brolier_chicken.jpg') }}" class="mr-3 w-25" alt="...">
                        <div class="media-body">
                            <h6 class="mt-0">Brolier Egg</h6>
                            <form action="#" method="POST" class="d-flex">
                                <input class="form-control form-control-sm w-50" name="egg" value="12" />
                                <input  type="submit" value="Rquest" class="btn btn-warning btn-sm  ml-2" />
                            </form>
                        </div>
                    </div>
               </div>
            </div>
            <div class="card">
                <div class="card-header">Today Sales</div>
                <div class="card-body">
                    <div class="media mb-3">
                        <img src="{{ asset('images/brolier_chicken.jpg') }}" class="mr-3 w-25" alt="...">
                        <div class="media-body">
                            <h6 class="mt-0">Brolier Chicken</h6>
                            130 KG
                        </div>
                    </div>
                    <div class="media mb-3">
                        <img src="{{ asset('images/brolier_chicken.jpg') }}" class="mr-3 w-25" alt="...">
                        <div class="media-body">
                            <h6 class="mt-0">Layer</h6>
                            10 KG
                        </div>
                    </div>
                    <div class="media">
                        <img src="{{ asset('images/brolier_chicken.jpg') }}" class="mr-3 w-25" alt="...">
                        <div class="media-body">
                            <h6 class="mt-0">Brolier Egg</h6>
                            130 
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>

    <!--  -->
    <div class="d-flex bd-highlight">
        <div class="bg-warning w-25 rounded">
            <form action="#" method="POST" class="container my-4" @submit="onSubmit">
                @csrf
                <div class="form-group">                
                    <input name="mobile" class="form-control form-control-sm" placeholder="Mobile" id="customer" autocomplete="off" v-model="form.customer.phone" :disabled="cartFlag ? true : false"/>
                </div>
                <!--  -->
                <div class="form-group">                
                    <input name="name" class="form-control form-control-sm" placeholder="Name" autocomplete="off" v-model="form.customer.name" :disabled="existingCustomer ? true : false"/>
                </div>
                <!--  -->
                <div class="form-group">                
                    <input name="email" type="hidden" class="form-control form-control-sm" placeholder="E-Mail" autocomplete="off" v-model="form.customer.email" :disabled="existingCustomer ? true : false"/>
                </div>
                <!--  -->
                <div class="form-group">                
                    <input name="location" type="hidden" class="form-control form-control-sm" placeholder="Location" autocomplete="off" v-model="form.customer.location" :disabled="existingCustomer ? true : false"/>
                </div>
                <h6 class="text-center my-4" v-if="existingCustomer"> @{{ form.customer.name }} </h6>
                <button type="submit" class="btn btn-sm btn-info mx-auto" v-else> Save Customer </button>
            </form>
            
            <table class="table table-striped table-sm small">
                <thead class="bg-dark small text-white">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Amt</th>
                            <th width="6"></th>
                        </tr>
                </thead>
                <tbody>
                    <tr v-for="cart in carts" :key="cart.id">
                        <td>@{{ cart.name }}</td>
                        <td v-currency>@{{ cart.attributes.rate }}</td>
                        <td>@{{ cart.attributes.weight }} <sup>kg</sup></td>                                                     
                        <td v-currency>@{{ cart.price }}</td>   
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST" class="mr-2 small" @submit="removeCart">
                                <input type="hidden" :value="cart.id" name='id' />
                                @csrf 
                                <input type="submit" value ="x" class="btn btn-sm btn-danger m-auto small py-0"/>
                            </form>                            
                        </td>                                              
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">                
                <form action="{{ route('cart.clear') }}" method="POST" class="mr-2" v-show="cartFlag">
                    @csrf 
                    <input type="submit" value ="Clear Cart" class="btn btn-sm btn-danger m-auto"/>
                </form>
                
                <form action="{{ route('cart.clear') }}" method="POST" v-show="cartFlag">
                    @csrf 
                    <input type="submit" value ="Generate Bill"  class="btn btn-sm btn-primary"/> 
                </form>    
            </div>
        </div>
        <div class="bd-highlight flex-grow-1 w-75">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6" v-for="product in products" :key="product.productName">
                        <div class="card mb-4" >                
                            <div class="card-body p-2 small">
                                <div class="bg-white d-flex p-0 justify-content-between  mb-3  font-weight-bold">
                                    <div class="wholesale">
                                        <span class="text-primary">Wholesale</span>
                                        <span class="ml-2" v-currency>@{{ product.wholesaleRate}}</span>
                                    </div>
                                    {{--  --}}
                                    <div class="retail">
                                        <span class="text-primary">Retail</span>
                                        <span class="ml-2" v-currency>@{{ product.retail_rate}}</span>
                                    </div>
                                </div>
                                 <div class="media">
                                     <img src="{{ asset('images/brolier_chicken.jpg') }}" class="mr-3 w-25" alt="...">
                                     <div class="media-body">
                                         <h6 class="mt-0 small">@{{ product.productName}}</h6>
                                         <form action="#" method="POST" class="font-weight-bold" @submit="addToCart">
                                             <div class="form-group d-flex">
                                                <label>Weight</label>
                                                <input class="form-control form-control-sm flex-grow-1 ml-2 rounded-0" name="weight"  @keyup="calateprice"  :data-wholesale-rate="product.wholesaleRate" :data-retail-rate="product.retail_rate" :data-product="product.productName"/>
                                                <span class="w-25 form-control border-left-0 form-control-sm bg-light rounded-0">@{{product.weight_unit}}</span>
                                                <input v-model="form.customer.phone" type="hidden"/>                                                
                                                <button type="submit" class="btn btn-sm btn-outline-success ml-2 px-2 py-0" style="display:none;"> <i data-feather="shopping-bag"></i> </button>
                                             </div>                                            
                                             <div class="d-flex">
                                                <label>Price</label>
                                                <strong class="ml-4 text-danger price"  v-currency>0</strong>
                                            </div> 
                                        </form>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
        <div class="bg-warning w-25 rounded">
            <h5 class="mt-2 mb-4 px-2"> Purchase History </h5>
            <table class="table table-striped table-sm small-xs">
                <thead class="bg-dark text-white">
                        <tr>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Receive Amt</th>                            
                        </tr>
                </thead>
                <tbody>
                    <tr v-for="history in purchaseHistory" :key="history.id">
                        <td>@{{ history.date }}</td>
                        <td v-currency>@{{ history.total }}</td>
                        <td v-currency>@{{ history.receive }}</td>                                                     
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
    
    @push('append-scripts')
    <script>
        $(document).ready(function () {
            $('#customer').mask('kg');
            $('#customer').mask('0000000000',{
                onComplete: function(phone) {                                        
                    //vue.rate;
                    $.post("{{ route('customer.existance') }}",{"phone":phone , "_token":vue.token},function(response){   
                        vue.existingCustomer = response.existance;
                        if(vue.existingCustomer){
                            _.assignIn(vue.form.customer,response.customer);                        
                        } else{
                            vue.form.customer.name = "";
                            vue.form.customer.email = "";
                            vue.form.customer.location = "";
                        }
                        
                        //vue.formUrl = (response.existance) ? "{{ route('cart.store') }}" : " {{ route('login') }}";                           
                    });
                },
                onChange:function(){
                    vue.existingCustomer = false;
                    vue.form.customer.name = "";
                    vue.form.customer.email = "";
                    vue.form.customer.location = "";
                }
            }); 
            // 
            $.get("/fetch/products",function(r){ 
                                                    vue.products = r.products; 
                                                    vue.purchaseHistory = r.purchaseHistory;  
                                                    vue.carts = r.carts;                                                    
                                                    if(_.size(vue.carts)){
                                                        $head = vue.carts[1]; 
                                                        vue.cartFlag = true;   
                                                        vue.existingCustomer=true;                                                   
                                                        _.assignIn(vue.form.customer,$head.attributes.customer); 
                                                    }                                                  
                                });
        });

        var vue = new Vue({
            el: '#app',
            data: {
                existingCustomer:false,
                token:$("[name='csrf-token']").attr("content"),
                formUrl:"{{ route('customer.store') }}",
                rate:0, 
                products:[], 
                purchaseHistory:[], 
                carts:[],    
                customer:'',
                cartFlag:false,
                form:{
                    customer :{
                        name:null,
                        email:null,
                        location:null,
                        phone:null,
                        _token:$("[name='csrf-token']").attr("content"),
                    },
                    cart :{
                        product:"",
                        customer:"",
                        weight:0,
                        amount:0,
                        rate:0,
                        _token:$("[name='csrf-token']").attr("content"),
                    }
                }
            },
            computed:{
                    // Make a request for a user with a given ID
                    // get only
                    totalAmount: function () {
                        // 
                        this.form.cart.customer = this.form.customer.phone;
                        this.form.cart.rate = this.rate;
                        // 
                        this.form.cart.amount =  parseFloat(this.form.cart.weight) * parseFloat(this.rate);
                        return this.form.cart.amount;
                    }                                              
            },
            methods: {
                onSubmit(event) {
                    event.preventDefault();
                    //                             
                    let url = "{{ route('customer.store') }}";
                    let data = this.form.customer;
                    
                    $.post(url,data,function(response){                                                                      
                        vue.existingCustomer = response.existance;
                        _.assignIn(vue.form.customer,response.customer);
                    });
                },
                todayRate(event) {
                    // this`.rate = this.$refs.product.selectedOptions[0].dataset.rate;
                },
                addToCart(event){
                    event.preventDefault();
                    $form = $(event.target);
                    // 
                    $form.find("[type=submit]").hide();
                    $el = $form.find('[name=weight]');
                    let url = "{{ route('cart.store') }}";
                    // 
                    var data = {
                                product:$el.data('product'),
                                customer:vue.form.customer.phone,
                                weight:$el.val(),
                                _token:$("[name='csrf-token']").attr("content"),
                            }; 
                    
                    $.post(url,data,function(response){                                  
                        vue.carts = response;
                        // console.log(response);
                        if(_.size(vue.carts))
                            vue.cartFlag = true;
                        else 
                            vue.cartFlag = false;
                        // 
                        $el.val(0);
                        $form.find(".pro-price").html(parseFloat(0));
                    });                    
                },
                removeCart(event){
                    event.preventDefault();
                    $form = $(event.target);
                    $.post($form.attr("action"),$form.serialize(),function(response){                                  
                        vue.carts = response;
                        // console.log(response);
                        if(_.size(vue.carts))
                            vue.cartFlag = true;
                        else 
                            vue.cartFlag = false;                        
                       
                    });
                },
                calateprice(event){
                    $el = $(event.target);   
                    $product =  $el.data('wholesaleRate');
                    $wholesaleRate = parseFloat($el.data('wholesaleRate'));
                    $retailRate = parseFloat($el.data('retailRate'));  

                                 
                    // 
                    if($el.val() > 0 && ($wholesaleRate > 0 || $retailRate > 0 )){
                        if($el.val() < 10){
                            $el.closest('form').find(".pro-price").html(parseFloat($el.val() * $retailRate));
                        }else {
                            $el.closest('form').find(".pro-price").html(parseFloat($el.val() * $wholesaleRate));
                        }
                        // 
                        $el.closest('form').find("[type=submit]").show();
                    }else{
                        $el.closest('form').find("[type=submit]").hide();
                        $el.closest('form').find(".pro-price").html(parseFloat(0));
                    }
                }
            },
        });
    </script>        
    @endpush
</x-app-layout>
