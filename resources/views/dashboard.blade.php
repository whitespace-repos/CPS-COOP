<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl flex mx-auto">
        <div class="sm:px-4 lg:px-3">
            <div class="p-6 w-60 mx-auto bg-white rounded-xl shadow-sm flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                </div>
                <div>
                    <div class="text-xl font-medium text-black">Products</div>
                    <p class="text-gray-500">5</p>
                </div>
            </div>
        </div>

        <div class="sm:px-4 lg:px-3">
            <div class="p-6 w-60 mx-auto bg-white rounded-xl shadow-sm flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                </div>
                <div>
                    <div class="text-xl font-medium text-black">Shops</div>
                    <p class="text-gray-500">3</p>
                </div>
            </div>
        </div>

        <div class="sm:px-4 lg:px-3">
            <div class="p-6 w-60 mx-auto bg-white rounded-xl shadow-sm flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                </div>
                <div>
                    <div class="text-xl font-medium text-black">Today Sale</div>
                    <p class="text-gray-500"><sup>INR</sup> 10,000</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
