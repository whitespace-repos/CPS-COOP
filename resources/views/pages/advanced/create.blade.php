<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-auto">
            {{ __('Edit Group Detail') }}            
        </h2>        
    </x-slot>   

    <div class="py-6 max-w-7xl  mx-auto" id="app">          
        <!--  -->            
        <form method="POST" action="{{ route('settings.store') }}" class="mb-5">
            <input type="hidden" name="group" value="{{ $setting->id }}" />
            @csrf            
            <!-- Shop Name -->
            <div class="flex mx-auto w-3/4 justify-center">
                <div class="flex-grow">                   
                    <label for="name" class="block text-sm font-medium text-gray-700">Group</label>
                    <div class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-gray-400 py-2 px-2 gray-400 text-white mr-4">{{ $group  }}</div>                      
                </div> 
                
                <div class="flex-grow ml-4">                   
                    <label for="name" class="block text-sm font-medium text-gray-700">Value</label>
                    <input type="text" name="value" id="value" autocomplete="value-level2" value="" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">                         
                </div>
                
                <div class="flex-grow ml-4">                   
                    <label for="name" class="block text-sm font-medium text-gray-700">Key</label>
                    <input type="text" name="key" id="key" autocomplete="key-level2" value="" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">                         
                </div>
                
                <x-button class="inline-flex w-20 px-5  py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 self-end text-center flex-none ml-5" >               
                    {{ __('Add') }}
                </x-button>  
            </div>             
        </form> 
        
        <!--  -->

        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200" >
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Group
                            </th>


                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Value
                            </th>

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Key
                            </th>
                                            
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($settings as $key => $setting)
                            <tr>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    {{ $setting->group }}
                                </td>

                                <td class="px-6 py-3 whitespace-nowrap">
                                    {{ $setting->value }}
                                </td>

                                <td class="px-6 py-3 whitespace-nowrap">
                                    {{ $setting->key }}
                                </td>
                            
                                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">                                    
                                    <form action="{{ route('settings.destroy',$setting->id) }}" method="POST" class="inline-block">
                                        @csrf 
                                        @method("DELETE")
                                        <!--  -->
                                        <input type="submit" class="bg-transparent cursor-pointer text-indigo-600 hover:text-indigo-900 mr-3"  value="Remove" />
                                    </form>
                                </td>
                            </tr> 
                        @endforeach                        
                        <!-- More people... -->
                    </tbody>
                </table>
            </div>
        </div>               
    </div>

</x-app-layout>
