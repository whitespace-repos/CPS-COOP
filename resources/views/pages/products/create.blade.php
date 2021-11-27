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
                <div>                   
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="product_name" id="name" autocomplete="name-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">                         
                </div> 
                <!--  -->
                <x-button class="mt-4">               
                    {{ __('Create Product') }}
                </x-button>  
            </form>
        </div>       
    </div>

</x-app-layout>
