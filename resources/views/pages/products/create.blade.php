<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-auto">
            {{ __('Create Product') }}            
        </h2>        
    </x-slot>

             

    <div class="py-6 max-w-7xl  mx-auto" id="app">  
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <!--  -->            
            <form method="POST" action="{{ route('product.store') }}">
                @csrf
                <div class="grid grid-flow-row grid-cols-2 grid-rows-2 gap-4">
                    <!-- Shop Name -->
                    <div>                   
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" name="product_name" id="name" autocomplete="name-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">                         
                    </div> 
                    
                    <div>
                        <label for="product" class="block text-sm font-medium text-gray-700">Weight Unit</label>
                        <select id="products" name="weight_unit"  autocomplete="weight-unit" data-placeholder="Choose Weight Unit"  class="select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                            @foreach($weightUnits as $unit)
                                <option value="{{ $unit->value }}"> {{ $unit->name }} ( {{ $unit->key }}) </option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label for="fields" class="block text-sm font-medium text-gray-700">Product Fields</label>
                        <select id="fields" name="fields"  autocomplete="fields-field" data-placeholder="Choose Rate Field"  class="select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                            @foreach($rateFeilds as $feild)
                                <option value="{{ $feild->value }}"> {{ $feild->name }}  </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--  -->
                <x-button class="mt-4">               
                    {{ __('Create Product') }}
                </x-button>  
            </form>
        </div>       
    </div>

</x-app-layout>
