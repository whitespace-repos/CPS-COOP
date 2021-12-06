<x-app-layout>    
    <!--  -->
    <form method="POST" action="{{ route('product.update',$product->id) }}" class="container p-5">
        @csrf
        @method('PATCH')   

        <div class="row">
            <!-- Shop Name -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="product_name" id="product_name"  value="{{ $product->product_name }}" class="form-control"> 
                </div>                
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Weight for wholesale</label>
                    <input type="text" name="wholesale_weight" id="wholesale_weight"  class="form-control numeric" value="{{ $product->wholesale_weight }}">  
                    <small class="help-block">Enter minimum weight for implementing wholesale rate </small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="product">Weight Unit</label>
                    <select id="products" name="weight_unit"  autocomplete="weight-unit" data-placeholder="Choose Weight Unit"  class="custom-select" >
                        @foreach($weightUnits->options as $unit)
                            <option value="{{ $unit->key }}" @if($product->weight_unit == $unit->key) {{_('selected')}} @endif > {{ $unit->name }} ( {{ $unit->key }}) </option>
                        @endforeach
                    </select>
                </div>                
            </div>
        </div> 

        <input type="submit" class="btn btn-primary px-5 btn-sm" value="Update Product" />
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

