<x-app-layout>
<a href="{{ route('product.create') }}" class="btn btn-primary btn-sm my-4">Add Product </a>
<div class="table-responsive">
    <table class="table table-striped table-sm  ">
        <thead class="bg-dark text-white">
            <tr>
                <th>Name</th>
                <th>Shop</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td> 
                        @foreach($product->shops as $shop)
                            <span class="badge badge-primary badge-pill">{{ $shop->shop_name }}</span>
                        @endforeach
                    </td>
                    <td> 
                        <a href="#">Edit</a>
                        <form action="{{ route('product.destroy',$product->id) }}" method="POST" class="d-inline-flex ml-2">                                
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
