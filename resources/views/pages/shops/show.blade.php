<x-app-layout>
    <h3 class="my-4 px-5">Stock Request </h3>
    <div class="table-responsive">
        <table class="table table-striped table-sm  ">
            <thead class="bg-dark text-white">
                <tr>                    
                    <th colspan="6">Shop</th>                   
                </tr>
            </thead>
            <tbody>
                @foreach($shop->stock_requests as $req)
                    <tr>
                        <td colspan="6">
                            <strong class="mr-5">{{ $req->shop->shop_name }}</strong>
                            <span class="mr-5"> By : {{ $req->stockRequestedBy->name ?? '' }}</span>
                            
                            @if($req->status == 'Processing' || $req->status == 'Sent' || $req->status == 'Received' || $req->status == 'Completed')
                                @if($req->payment_method == "EMI")
                                    <span class="mr-5"> Payment Method : {{ $req->payment_method ?? '' }}</span>
                                    <span class="mr-5"> Payment Period : {{ $req->payment_period ?? '' }}</span>
                                @else 
                                    <span class="mr-5"> Payment Option : <b>{{ $req->payment_method ?? '' }} </b> </span>
                                @endif 
                            @endif                             

                            @if(auth()->user()->hasRole('Admin'))
                                @if($req->status == 'Requested')
                                    <form class="d-inline" method="GET" action="{{ route('approve.stock.request',$req->id ) }}">
                                        @csrf 
                                        <input type="number" placeholder="Supply Rate" name="supply_rate" class="rounded" />
                                        <input type="submit" value="Approved" class="btn btn-primary btn-sm" />
                                    </form>                                    
                                @endif

                                @if($req->status == 'Processing')
                                    <a href="{{ route('stock.request.detail',$req->id) }}" id="showStockRequestDetail" class="btn btn-primary btn-sm">Send</a>
                                @endif

                                @if($req->status == 'Processing' || $req->status == 'Requested' || $req->status == 'Approved')
                                    <a href="#" class="btn btn-secondary btn-sm">Rejected</a>
                                @endif

                                
                                @if($req->status == 'Received')
                                    <a href="{{ route('completed.stock',$req->id) }}" class="btn btn-success btn-sm">Completed</a>
                                @endif                                
                            @endif 

                            @if(auth()->user()->hasRole('Employee') && $req->status == 'Approved')
                            <form class="d-inline" method="POST" action="{{ route('stock.request.payment.option',$req->id) }}">
                                @csrf 
                                <label class="mr-4">Supply Rate : <b> <sup> INR </sup> {{ $req->supply_rate }}</b></label>
                                <select name="payment_option" required >                                    
                                    <option value="Pay When Stock Received">Pay When Stock Received</option>
                                    <option value="Pay After Sales Completed">Pay After Sales Completed</option>
                                </select>
                                <input type="submit" class="btn btn-primary btn-sm " value="Save Payment Option" />
                            </form>
                            @endif                          
                            @if(auth()->user()->hasRole('Employee') && $req->status == 'Sent')
                                <a href="{{ route('stock.request.detail',$req->id) }}" id="showStockRequestDetail" class="btn btn-primary btn-sm">Received</a>
                            @endif

                        </td>
                    </tr>
                    @foreach($req->requested_products as $product)
                        @if($loop->first)
                            <tr  class="bg-warning  text-white">                    
                                <th class="px-4"></th>
                                <th>Product</th>
                                <th>Stock Request</th>
                                <th>Stock Remaining</th>   
                                <th>Stock Sent </th>
                                <th>Stock Receive </th>                                     
                                <th>Stock Wastage </th>                                     
                                <th>Status</th>                    
                            </tr>
                        @endif
                        <tr>
                            <td></td>
                            <td>{{ $product->product->product_name }}</td>                        
                            <td>{{ $product->stock_request .' '. $product->product->weight_unit }}</td>
                            <td>{{ $product->current_stock .' '. $product->product->weight_unit  }}</td>  
                            <td>{{ $product->stock_sent .' '. $product->product->weight_unit  }}</td>  
                            <td>{{ $product->stock_received .' '. $product->product->weight_unit  }}</td>  
                            <td>{{ $product->stock_wastage .' '. $product->product->weight_unit  }}</td>                   
                            <td>{{ $product->status }}</td>                 
                        </tr>
                    @endforeach    
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal" id="stockRequestDetail" tabindex="-1" role="dialog"></div>
    @push('append-scripts')
        <script>
            $(document).ready(function () {
                $("#showStockRequestDetail").on("click",function(e){
                    e.preventDefault();
                                    
                    $("#stockRequestDetail")
                                            .load($(this).attr("href"))
                                            .modal("show")
                                            .on('hidden.bs.modal', function (e) {
                                                    $("#stockRequestDetail").html("");
                                            });
                });
            });
        </script>    
    @endpush
    
</x-app-layout>
