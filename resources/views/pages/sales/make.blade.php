<x-coop-layout>
    <section id="app">
        <div class="BodyTop">
            <div class="row">
                <div class="col-lg-6">
                    <div class="current_stock">
                        <div class="CS_header">
                            <h2>Current Stock</h2>
                            <a href="#" class="Btn" data-toggle="modal" data-target="#myModal">Stock Request</a> 
                        </div>
                        <div class="CS_body">
                            <div class="owl-carousel owl-theme">
                                <div class="item">
                                    <div class="itemBox"> <span class="img"><img src="{{ asset('assets/img/hean.png') }}" alt="icon"></span> <span class="txt">
                                        <h3>243 kg</h3>
                                        <p>Broiler Live</p>
                                        </span> 
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="itemBox"> <span class="img"><img src="{{ asset('assets/img/egg.png') }}" alt="icon"></span> <span class="txt">
                                        <h3>3500 Nr.</h3>
                                        <p>Eggs</p>
                                        </span> 
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="itemBox"> <span class="img"><img src="{{ asset('assets/img/hean1.png') }}" alt="icon"></span> <span class="txt">
                                        <h3>243 kg</h3>
                                        <p>Layer Live</p>
                                        </span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="today_sales">
                        <div class="CS_header">
                            <h2>Today's Sales</h2>
                        </div>
                        <div class="CS_body">
                            <div class="owl-carousel today-carousel owl-theme">
                                <div class="item">
                                    <div class="itemBox"> <span class="img"><img src="{{ asset('assets/img/hean.png') }}" alt="icon"></span> <span class="txt">
                                        <h3>23 kg</h3>
                                        <p>Broiler Live</p>
                                        <h4>Rs.3,450</h4>
                                        </span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="itemBox"> <span class="img"><img src="{{ asset('assets/img/egg.png') }}" alt="icon"></span> <span class="txt">
                                        <h3>9000 Nr.</h3>
                                        <p>Eggs</p>
                                        <h4>Rs.45,000</h4>
                                        </span> 
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="itemBox"> <span class="img"><img src="{{ asset('assets/img/hean1.png') }}" alt="icon"></span> <span class="txt">
                                        <h3>23 kg</h3>
                                        <p>Layer Live</p>
                                        <h4>Rs.3,450</h4>
                                        </span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="BodyBottom">
            <div class="row">
                <div class="col-lg-3">
                    <div class="customer_info">
                        <div class="CI_header">
                            <h3>Customer Info</h3>
                        </div>
                        <div class="CI_body">
                            <div class="info_input">
                                <ul>
                                    <li>
                                        <input placeholder="Mobile" id="customer" autocomplete="off" v-model="form.customer.phone" :disabled="cartFlag ? true : false">
                                    </li>
                                    <li :class="{'border-0 text-danger': existingCustomer }">
                                        <h4 v-if="existingCustomer" class="text-center"> @{{ form.customer.name }}</h4>
                                        <input name="name"  placeholder="Name" autocomplete="off" v-model="form.customer.name"  v-else/>
                                    </li>
                                </ul>
                            </div>
                            <div class="info_table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Rate</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th></th>
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
                                                    <button class="btn" type="submit"><img src="{{ asset('assets/img/cross_btn.png') }}" alt=""></button>
                                                </form> 
                                            </td>                                           
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Total Amount:</strong></td>
                                            <td colspan="2"><strong>Rs.0</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-primary" type="button" >Generate Bill</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 ">                                       
                    <div class="customer_info" v-if="existingCustomer">
                        <div class="CI_header">
                            <h3>Stock Request</h3>
                        </div>
                        <div class="CI_body">
                            <div class="Stock_list" id="style-3">
                                <ul>
                                    <li v-for="product in products" :key="product.productName"> 
                                        <span class="product_info"> 
                                            <em class="img"><img src="{{ asset('assets/img/hean.png') }}" alt="icon"></em> 
                                            <em class="txt">
                                                <h4>@{{ product.productName}}</h4>
                                            </em> 
                                        </span> 
                                        <span class="product_radio">
                                            <label class="radioPart">
                                                Retail:
                                                <p v-currency>@{{ product.retail_rate}}</p>
                                                <input type="radio"  name="radio1" class="tbName" data-btn="submit1">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radioPart">
                                                Wholesale:
                                                <p v-currency>@{{ product.wholesaleRate}}</p>
                                                <input type="radio" name="radio1" class="tbName" data-btn="submit1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </span>
                                        <span class="product_btn">
                                            <form action="#" method="POST" class="font-weight-bold" @submit="addToCart">
                                                <div class="input-group">
                                                    <input  class="form-control" placeholder="10"  name="weight"  @keyup="calateprice"  :data-wholesale-rate="product.wholesaleRate" :data-retail-rate="product.retail_rate" :data-product="product.productName" :data-wholesale-weight="product.wholesaleWeight" autocomplete="off"/>
                                                    <input v-model="form.customer.phone" type="hidden"/>
                                                    <div class="input-group-append">
                                                        <small class="input-group-text">@{{product.weight_unit}}</small>
                                                        <p class="price" v-currency>0</p>
                                                    </div>
                                                    <button class="btn btn-primary submit" type="submit" disabled="disabled">ADD</button>
                                                </div>
                                           </form>                                            
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="customer_info black" v-else>
                        <img src="{{ asset('assets/img/blank_img1.png') }}" alt="icon">
                        <h6>Please add customer information to show order list.</h6>                    
                    </div> 
                </div>
                {{--  --}}     
                <div class="col-lg-3 displayNoneIpad">
                    <div class="Purchase_History" v-if="existingCustomer">
                        <div class="PH_header">
                            <h3>Purchase History</h3>
                        </div>
                        <div class="PH_body">                   
                            <div class="table-responsive">
                                <table class="table table-fixed">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="col-3">Date</th>
                                            <th scope="col" class="col-4">Total</th>
                                            <th scope="col" class="col-5">Received Amt</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyBar">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="Purchase_History black-history " v-else>                    
                        <img src="{{ asset('assets/img/blank_img2.png') }}" alt="icon">
                        <h6>No History Available</h6>                    
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                        $form.find("[type=submit]").attr("disabled","disabled");
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
                        $wholesaleWeight = parseInt($el.data('wholesaleWeight')); 
                                    
                        // 
                        if($el.val() > 0 && ($wholesaleRate > 0 || $retailRate > 0 )){
                            if($el.val() < $wholesaleWeight){
                                $el.closest('form').find(".pro-price").html(parseFloat($el.val() * $retailRate));
                            }else {
                                $el.closest('form').find(".pro-price").html(parseFloat($el.val() * $wholesaleRate));
                            }
                            // 
                            $el.closest('form').find("[type=submit]").removeAttr("disabled");
                        }else{
                            $el.closest('form').find("[type=submit]").attr("disabled","disabled");
                            $el.closest('form').find(".pro-price").html(parseFloat(0));
                        }
                    }
                },
            });
        </script>        
    @endpush
</x-coop-layout>

