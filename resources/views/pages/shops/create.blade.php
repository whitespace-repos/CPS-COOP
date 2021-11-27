<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-auto">
            {{ __('Create Shop') }}            
        </h2>        
    </x-slot>

             

    
    <div class="py-6 max-w-7xl  mx-auto" id="app">  
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
             <!--  -->
            
            <form method="POST" action="{{ route('shop.store') }}">
                @csrf
                <div class="grid grid-flow-row grid-cols-2 grid-rows-2 gap-4">
                    <!-- Shop Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Shop Name</label>
                        <input type="text" name="shop_name" id="shop_name" autocomplete="name-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                  
                    <div>
                        <label for="shop_dimentions" class="block text-sm font-medium text-gray-700">Shop Dimentions</label>
                        <input type="text" name="shop_dimentions" id="shop_dimentions" autocomplete="shop_dimentions" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">
                            Stock Capacity <small class="mt-2 text-xs text-gray-400" >{{ _('Stock calculated in kg ')}} </small> 
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">                            
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                Per Day
                            </span>                            
                            <input type="number" name="stock_capacity_per_day" id="stock_capacity_per_day" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="0" >
                        </div>
                    </div>

                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">
                            Max Sale Estimate <small class="mt-2 text-xs text-gray-400" >{{ _('Amount calculated in INR ')}} </small> 
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">                            
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                Per Day
                            </span>                            
                            <input type="number" name="max_sale_estimate_per_day" id="max_sale_estimate_per_day" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="0" >
                        </div>
                    </div>

                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">
                            Distance From CPS
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                kg
                            </span>
                            <input type="number" name="distance_from_cps" id="distance_from_cps" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="0" v-model="vue.form.cart.weight">
                        </div>
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">
                            Estimated Start Date
                        </label>
                        <input type="text" name="estimated_start_date" id="estimated_start_date" autocomplete="name-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">                        
                    </div> 
                    
                    <div>
                        <label for="product" class="block text-sm font-medium text-gray-700">Product</label>
                        <select id="products" name="products[]"  autocomplete="product-name" data-placeholder="Choose Product"  class="select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple="true">
                            <option></option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"> {{ $product->product_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div> 
 
                <!--  -->
                <x-button class="mt-5">                
                    {{ __('Create Shop') }}
                </x-button>  
            </form>
        </div>       
    </div>
    @push('append-scripts')
        <script>
            $(document).ready(function(){
                $(".select2").select2();
            })
        </script>
    @endpush
</x-app-layout>
