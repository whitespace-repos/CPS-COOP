<x-app-layout>
    <h3 class="my-4 px-5">Stock Request </h3>
    <div class="table-responsive">
        <table class="table table-striped table-sm  ">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Product</th>
                    <th>Shop</th>
                    <th>Stock Request</th>
                    <th>Stock Remaining</th>
                    <th>Payment</th>
                    <th>Payment Period</th>
                    <th>Rquest Generate By</th>
                    <th>status</th>                    
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{ $stock->product->product_name }}</td>
                        <td>{{ $stock->shop->shop_name }}</td>
                        <td>{{ $stock->stock_request }}</td>
                        <td>{{ $stock->stock_remaining }}</td>
                        <td>{{ $stock->payment_method }}</td>
                        <td>{{ $stock->payment_period }}</td>
                        <td>{{ $stock->stock_requested_by }}</td>
                        <td>{{ $stock->status }}</td>                 
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
