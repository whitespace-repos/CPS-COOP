<x-app-layout>    
    <!--  -->
    <form method="POST" action="{{ route('product.store') }}" class="container p-5" enctype="multipart/form-data">
        @csrf
        
        <div class="row justify-content-center">
            <!-- Shop Name -->
            <div class="col-md-5">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="product_name" id="product_name"  class="form-control"> 
                </div>                
            </div>


            <div class="col-md-5">
                <div class="form-group">
                    <label for="product">Weight Unit</label>
                    <select id="products" name="weight_unit"  autocomplete="weight-unit" data-placeholder="Choose Weight Unit"  class="custom-select" >
                        @foreach($weightUnits->options as $unit)
                            <option value="{{ $unit->value }}"> {{ $unit->name }} ( {{ $unit->key }}) </option>
                        @endforeach
                    </select>
                </div>                
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <label for="name">Weight for wholesale</label>
                    <input type="text" name="wholesale_weight" id="wholesale_weight"  class="form-control numeric">  
                    <small class="help-block">Enter minimum weight for implementing wholesale rate </small>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="form-group">
                    <label for="name">Upload Product Image</label>
                    <input type="file" name="product_image" id="product_image"  class="form-control p-1">  
                    <small class="help-block">Valid Type : only image type is allowed</small>
                </div>
            </div>


            <div class="col-md-10">
                <div class="form-group">
                    <label for="stock" class="d-block">Stock</label>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="stock-yes" name="stock" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="stock-yes">Yes</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="stock-no" name="stock" class="custom-control-input" value="0" checked="checked">
                        <label class="custom-control-label" for="stock-no">No</label>
                      </div>
                </div>
            </div>
            {{--  --}}
            <div class="col-md-10 mt-2">
                <input type="submit" class="btn btn-primary px-5 btn-sm" value="Add Product" />
            </div>        
        </div> 

        
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

