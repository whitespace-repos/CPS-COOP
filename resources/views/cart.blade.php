<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart Detail') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl flex mx-auto">        
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th> 

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
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
                        @foreach ($cartItems as $item)
                            <tr>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->attributes->customer->name }}
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $item->attributes->customer->phone }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->name }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">                               
                                    {{ $item->attributes->weight }} <sup>kg</sup> 
                                </td>
                            
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <sup>INR</sup> {{ $item->attributes->rate }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <sup>INR</sup> {{ $item->price }}
                                </td>
                            </tr>
                        @endforeach
                        <!-- More people... -->
                    </tbody>
                    <tfooter class="bg-gray-50">
                        <tr>   
                            <th colspan="3"  class="text-left mx-5">
                                 <!--  -->
                                <form action="{{ route('cart.clear') }}" method="POST" v-if="cart > 0" class="mx-4">
                                    @csrf 
                                    <input type="text" name="customer" id="customer" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 inline rounded rounded-r-md sm:text-sm border-gray-300" placeholder="Receive Amount" />                            
                                    <x-button>                
                                        {{ __('Generate Bill') }}
                                    </x-button>  
                                </form>    
                            </th>                                                
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Total Amount
                            </th> 

                            <th scope="col" class="px-6 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">
                                <sup>INR</sup> {{ Cart::getTotal() }}
                            </th>                    
                        </tr>
                    </tfooter>
                </table>                
            </div>           
        </div>               
    </div>
</x-app-layout>
