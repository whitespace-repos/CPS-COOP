<x-app-layout>
    <x-slot name="header">
        <div class="flex" id="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-auto">
                {{ __('Make Sale') }}            
            </h2>
            <a href="{{ route('cart.list') }}" class="mr-3"><i data-feather="shopping-cart" class="inline mr-1 self-center"></i> @{{ cart }} </a>

            <form action="{{ route('cart.clear') }}" method="POST" v-if="cart > 0">
                @csrf 
                <x-button>                
                    {{ __('clear Cart') }}
                </x-button>  
            </form>

           
        </div>        
    </x-slot>

             

    <div class="py-6 max-w-7xl  mx-auto" id="app">  
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
             <!--  -->
            
            <form method="POST" v-bind:action="formUrl"  @submit="onSubmit">
                @csrf
                <div class="grid grid-flow-row grid-cols-2 grid-rows-2 gap-4">
                    <div>
                        <label for="customer" class="block text-sm font-medium text-gray-700">
                             Customer  <small class="mt-2 text-xs text-gray-400" v-if="existingCustomer">Existing Customer : @{{ customer.name }}  - @{{ customer.email }} </small> 
                        </label>
                        
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                +91
                            </span>
                            <input type="text" name="customer" id="customer" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="customer phone number" v-model="form.customer.phone">                            
                        </div>                       
                       
                    </div>

                    <div v-if="existingCustomer == false">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" autocomplete="name-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="form.customer.name">
                    </div>

                    <div v-if="existingCustomer == false">
                        <label for="email" class="block text-sm font-medium text-gray-700">E-Mail</label>
                        <input type="text" name="email" id="email" autocomplete="email-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="form.customer.email">
                    </div>

                    <div v-if="existingCustomer == false">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" autocomplete="location" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" v-model="form.customer.location">
                    </div>

                    <div v-if="existingCustomer">
                        <label for="product" class="block text-sm font-medium text-gray-700">Product</label>
                        <select id="product" name="product" ref="product" autocomplete="product-name" @change="todayRate" data-placeholder="Choose Product"  class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="vue.form.cart.product">
                            <option></option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-rate="{{ $loop->iteration }}"> {{ $product->product_name }}  ( {{ 'INR '.$loop->iteration }} )</option>
                            @endforeach
                        </select>
                    </div>

                    <div v-if="existingCustomer">
                        <label for="weight" class="block text-sm font-medium text-gray-700">
                             Weight
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                kg
                            </span>
                            <input type="number" name="weight" id="weight" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="0" v-model="vue.form.cart.weight">
                        </div>
                    </div>

                    <div v-if="existingCustomer">
                        <label for="amount" class="block text-sm font-medium text-gray-700">
                             Amount <small class="mt-2 text-xs text-gray-400" v-if="existingCustomer"> Weight  * Product Rate i.e @{{ vue.form.cart.weight }} * @{{ vue.rate }} </small>
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                INR
                            </span>
                            <input type="number" name="amount" id="amount" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300  bg-gray-200" placeholder="0" v-bind:value="totalAmount" disabled/>
                        </div>
                    </div>                                   
                </div> 
                
                
                <x-button class="mt-3" v-if="existingCustomer">                
                    {{ __('Add To Cart') }}
                </x-button>  
                <!--  -->
                <x-button class="mt-3" v-else>                
                    {{ __('Save Customer') }}
                </x-button>  
            </form>
        </div>       
    </div>

    <div class="max-w-7xl flex mx-auto">  
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <!--  -->
                    <caption class="text-left py-3 px-6 text-bold">Recent Logs</caption>
                    <!--  -->
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Weight
                            </th> 

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rate
                            </th> 

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount
                            </th> 
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                Brolier Live
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                Ankit Sethi
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    9816213806
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">                               
                                 10 <sup>kg</sup> 
                            </td>
                        
                            <td class="px-6 py-4 whitespace-nowrap">
                                <sup>INR</sup> 9
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <sup>INR</sup> 90
                            </td>
                        </tr>                       
                        <!-- More people... -->
                    </tbody>
                </table>
            </div>
        </div>               
    </div>
    <script>
        $(document).ready(function(){
            // 
            table = cps('Rate');
            // 
            $("select").select2();
            const createRecord = async (fields) => {
    const createdRecord = await table.create(fields);
    console.log(minifyRecord(createdRecord));
};

            $('#customer').mask('0000000000',{
                onComplete: function(phone) {                     
                    //vue.rate;
                    $.post("{{ route('customer.existance') }}",{"phone":phone , "_token":vue.token},function(response){   
                        vue.existingCustomer = response.existance;
                        vue.customer = response.customer;
                        vue.form.customer.name = "";
                        vue.form.customer.email = "";
                        vue.form.customer.location = "";
                        // 
                        vue.formUrl = (response.existance) ? "{{ route('cart.store') }}" : " {{ route('login') }}";                           
                    });
                },
                onChange:function(){
                    vue.existingCustomer = false;
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
                customer:{
                    name:'',
                    email:''                    
                },
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
                            let url = (this.existingCustomer) ? "{{ route('cart.store') }}" : " {{ route('customer.store') }}";
                            let data = (this.existingCustomer) ? this.form.cart : this.form.customer;

                            console.log(data);
                            $.post(url,data,function(response){                                  
                                vue.existingCustomer  = true;              
                                vue.customer = response.customer; 
                                vue.form.cart.weight = 0;
                                vue.$refs.product.selectedIndex = 0;
                                header.cart = response.totalCartItem;
                            });
                        },
                        todayRate(event) {
                            this.rate = this.$refs.product.selectedOptions[0].dataset.rate;
                        },
            },
        });

        var header = new Vue({
            el: '#header',
            data: {
                cart:"{{ Cart::getTotalQuantity()}}"
            }
        })
            
    </script>
</x-app-layout>
