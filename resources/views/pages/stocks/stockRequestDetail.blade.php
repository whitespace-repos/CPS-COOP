<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="@role('Admin'){{ route('send.stock',$stockRequest->id ) }} @else {{ route('received.stock',$stockRequest->id ) }} @endrole">
        <div class="modal-header">
            <h5 class="modal-title">Stock Request Detail ( Supply Rate : <sup> INR </sup> {{ $stockRequest->supply_rate }} ) </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table">
            
            @foreach($stockRequest->requested_products as $product)
                @if($loop->first)
                    <tr  class="bg-warning  text-white">                    
                        <th class="px-4"></th>
                        <th>Product</th>
                        @role('Admin')
                            <th> Sent Stock<th>
                        @else 
                            <th> Sent Stock</th>
                            <th> Receive Stock</th> 
                        @endrole                        
                        <th>Stock Request</th>
                        <th>Stock Remaining</th>                                                               
                        <th>Status</th>                    
                    </tr>
                @endif
                <tr>
                    <td></td>
                    <td>{{ $product->product->product_name }}</td>    
                    @role('Admin')
                        <td><input name="{{ $product->id }}" value="{{ $product->stock_request }}" style="width:50px"/> {{ $product->product->weight_unit }}</td>                      
                    @else 
                        <td>{{ $product->stock_sent .' ' .$product->product->weight_unit }}</td>    
                        <td><input name="{{ $product->id }}" value="{{ $product->stock_sent }}" style="width:50px"/> {{ $product->product->weight_unit }}</td>                      
                    @endrole
                    <td>{{ $product->stock_request .' '. $product->product->weight_unit }}</td>
                    <td>{{ $product->current_stock .' '. $product->product->weight_unit  }}</td>                                     
                    <td>{{ $product->status }}</td>                 
                </tr>
            @endforeach             
            </table>   
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </form>
    </div>
</div>