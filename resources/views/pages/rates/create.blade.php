<x-app-layout>    
    <!--  -->
    <form method="POST" action="{{ route('rate.store') }}" class="container p-5">
        @csrf
        
        <div class="row">
            <!-- Shop Name -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Date</label>
                    <div class="form-control bg-light">{{ Carbon::now()->format('d-m-Y') }} </div>
                </div>                
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="product">Product</label>
                    <select id="products" name="product_id"  autocomplete="product-name" data-placeholder="Choose Product"  class="custom-select w-100">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"  @if(!empty($rate) && $rate->product_id == $product->id) {{ _('selected') }} @endif > {{ $product->product_name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="wholesale_rate">Wholesale Rate</label>
                    <input type="text" name="wholesale_rate" id="wholesale_rate"  class="form-control numeric"  value="{{ $rate->wholesale_rate ?? 0 }}"/>
                </div>                
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="supply_rate">Supply Rate</label>
                    <input type="text" name="supply_rate" id="supply_rate"  class="form-control numeric " value="{{ $rate->supply_rate ?? 0 }}"/>
                </div>                
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="retail_rate">Retail Rate</label>
                    <input type="text" name="retail_rate" id="retail_rate"  class="form-control numeric" value="{{ $rate->retail_rate ?? 0 }}"/>
                </div>                
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="other_rate">Other Rate</label>
                    <input type="text" name="other_rate" id="other_rate"  class="form-control numeric" value="{{ $rate->other_rate ?? 0 }}"/>
                </div>                
            </div>
        </div> 

        <input type="submit" class="btn btn-primary px-5 btn-sm" value="Add Rate" />
    </form>
    @push('append-scripts')
        <script>
            $(document).ready(function(){
                $(".select2").select2();                
                $(".numeric").numeric();
            })
        </script>
    @endpush
</x-app-layout>
