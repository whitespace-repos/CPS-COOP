<x-app-layout>
    <a href="{{ route('shop.create') }}" class="btn btn-primary btn-sm my-4 px-5">Add Shop </a>

    <div class="table-responsive">
        <table class="table table-striped table-sm  ">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Name</th>
                    <th>Number of Products</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shops as $shop)
                    <tr>
                        <td>{{ $shop->shop_name }}</td>
                        <td> 
                            @foreach($shop->products as $product)
                                <span class="badge badge-primary badge-pill">{{ $product->product_name }}</span>
                            @endforeach
                        </td>
                        <td> 
                            <a href="{{ route('shop.edit',$shop->id) }}">Edit</a>
                            <form action="{{ route('shop.destroy',$shop->id) }}" method="POST" class="d-inline-flex">                                
                                @csrf 
                                @method("DELETE")
                                <!--  -->
                                <input type="submit" class="py-0 btn btn-link btn-xs"  value="Remove" />
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
