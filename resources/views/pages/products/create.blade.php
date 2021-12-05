<x-app-layout>


    <form method="POST" action="{{ route('product.store') }}" class="form-inline w-75 justify-content-center my-4 mx-auto">
        @csrf       
        <div class="form-group m-2 flex-column">                   
            <label for="name" class="mr-auto mb-2">Product Name</label>
            <input type="text" name="product_name" id="product_name"  class="form-control">                         
        </div> 
        
        <div class="form-group m-2 flex-column">
            <label for="product"  class="mr-auto mb-2">Weight Unit</label>
            <select id="products" name="weight_unit"  autocomplete="weight-unit" data-placeholder="Choose Weight Unit"  class="custom-select" >
                @foreach($weightUnits->options as $unit)
                    <option value="{{ $unit->value }}"> {{ $unit->name }} ( {{ $unit->key }}) </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-dark m-2 px-4 mt-auto">Create Product</button>
    </form>


</x-app-layout>
