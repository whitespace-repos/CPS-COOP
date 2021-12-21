<x-app-layout>    
    <!--  -->
    <form method="POST" action="{{ route('shop.update',$shop->id) }}" class="container p-5">
        @csrf
        @method('PATCH')
        <div class="row">
            <!-- Shop Name -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Shop Name</label>
                    <input type="text" name="shop_name" id="shop_name" value="{{ $shop->shop_name }}" class="form-control" />
                </div>                
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="shop_dimentions">Shop Name</label>
                    <input type="text" name="shop_dimentions" id="shop_dimentions" value="{{ $shop->shop_dimentions }}" class="form-control" />
                </div>                
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="stock_capacity_per_day">Shop Name</label>
                    <input type="text" name="stock_capacity_per_day" id="stock_capacity_per_day" value="{{ $shop->stock_capacity_per_day }}" class="form-control" />
                </div>                
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="max_sale_estimate_per_day">
                        Max Sale Estimate <small class="mt-2 text-xs text-gray-400" >{{ _('Amount calculated in INR ')}} </small> 
                    </label>
                    <input type="text" name="max_sale_estimate_per_day" id="max_sale_estimate_per_day" value="{{ $shop->max_sale_estimate_per_day }}" class="form-control" />
                </div>                
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="distance_from_cps">
                        Distance From CPS
                    </label>
                    <input type="text" name="distance_from_cps" id="distance_from_cps" value="{{ $shop->distance_from_cps }}" class="form-control" />
                </div>                
            </div>  


            <div class="col-md-4">
                <div class="form-group">
                    <label for="distance_from_cps">
                        Estimated Start Date
                    </label>
                    <input type="text" name="estimated_start_date" id="estimated_start_date" value="{{ $shop->estimated_start_date }}" class="form-control" />
                </div>                
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="product">Product</label>
                    <select id="products" name="products[]"  autocomplete="product-name" data-placeholder="Choose Product"  class="select2 w-100" multiple="true">
                        <option></option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @if($shopProducts->contains($product->id)) {{ _('selected') }} @endif > {{ $product->product_name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> 

        <input type="submit" class="btn btn-primary px-5 btn-sm" value="Update" />
    </form>
    @push('append-scripts')
        <script>
            $(document).ready(function(){
                $(".select2").select2();
            })
        </script>
    @endpush
</x-app-layout>
