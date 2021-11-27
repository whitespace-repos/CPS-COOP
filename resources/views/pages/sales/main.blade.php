<x-cps-layout>
    <h4 class="mt-4">Bhuvan Sales</h4>  
    
    <hr class="mb-5 mt-4" />    
    <table class="table Sales-Grid table-striped table-hover small">
        <thead class="thead-dark small">
            <tr class="small">
                <th width="20">#</th>
                <th width="100">Date</th>
                <th>Sales retail Live (Kg)</th>
                <th>Sales Wholesale Live (Kg)</th>
                <th>Amount wholesale Live</th>
                <th>Sales wholesale chicken (Kg)</th>
                <th>Amount wholesale chicken</th>
                <th>Convertion Rate</th>
                <th>Sales retail layer (Kg)</th>
                <th>Sales wholesale layer (Kg)</th>
                <th>Amount wholesale layer</th>
                <th>Sales wholesale layer (Kg)</th>
            </tr>
        </thead>
        <tbody>     
            @foreach($sales as $sale)
            <tr>               
                <td><kbd>#{{ $loop->iteration }}</kbd></td>               
                <td>{{ $dispalyDate('Rate',$sale['Date'][0]) }}</td>        
                <td>{{ $sale['Sales retail Live (Kg)'] }} </td>
                <td>{{ $sale['Sales Wholesale Live (Kg)'] }} </td>
                <td>@convert($sale['Amount wholesale Live']) </td>
                <td>{{ $sale['Sales wholesale chicken (Kg)'] }} </td>
                <td>@convert($sale['Amount wholesale chicken']) </td>
                <td>@convert($sale['Convertion Rate']) </td>
                <td>{{ $sale['Sales retail layer (Kg)'] }} </td>
                <td>{{ $sale['Sales wholesale layer (Kg)'] }} </td>   
                <td>@convert($sale['Amount wholesale layer']) </td>   
                <td>{{ $sale['Sales Eggs (Nr)'] }}</td>   
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(function(){
            var table = $('.Sales-Grid').DataTable({
                                                        "order": [[ 1, "desc" ]]
                                    });   
        
            table.button().add( 0,[
                {
                    text: 'Billing',
                    className: 'btn btn-warning btn-sm mx-1 rounded px-5 ',
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('sales.create') }}"
                    }
                }
            ]);
        });
    </script>

</x-cps-layout>
