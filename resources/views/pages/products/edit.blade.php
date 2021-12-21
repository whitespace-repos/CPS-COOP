<x-app-layout>    
    <!--  -->
    <form method="POST" action="{{ route('product.update',$product->id) }}" class="container p-5" enctype="multipart/form-data">
        @csrf
        @method('PATCH')   

        <div class="row justify-content-center">

            <div class="col-md-10 text-center my-4">
                <img src="{{ $product->product_image }}" width="40"/>
            </div>
            <!-- Shop Name -->
            <div class="col-md-5">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="product_name" id="product_name"  value="{{ $product->product_name }}" class="form-control"> 
                </div>                
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <label for="product">Weight Unit</label>
                    <select id="products" name="weight_unit"  autocomplete="weight-unit" data-placeholder="Choose Weight Unit"  class="custom-select" >
                        @foreach($weightUnits->options as $unit)
                            <option value="{{ $unit->key }}" @if($product->weight_unit == $unit->key) {{_('selected')}} @endif > {{ $unit->name }} ( {{ $unit->key }}) </option>
                        @endforeach
                    </select>
                </div>                
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <label for="name">Weight for wholesale</label>
                    <input type="text" name="wholesale_weight" id="wholesale_weight"  class="form-control numeric" value="{{ $product->wholesale_weight }}">  
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
                <input type="submit" class="btn btn-primary px-5 btn-sm" value="Update Product" />
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

