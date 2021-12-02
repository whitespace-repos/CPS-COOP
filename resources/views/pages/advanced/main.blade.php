<x-app-layout>
    <x-slot name="header">
        <div class="flex" id="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-auto">
                {{ __('Advanced Setting') }}         
            </h2>           
        </div>  
    </x-slot>

    <div class="py-12 max-w-7xl flex mx-auto">        
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200" >
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Group
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
                            
                                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">                                    
                                    <a href="{{ route('settings.edit',$setting->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
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
