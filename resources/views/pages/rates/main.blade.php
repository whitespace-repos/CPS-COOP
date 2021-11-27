<x-cps-layout>
    <h4 class="mt-4">Employees</h4>
    
    <hr class="mb-5 mt-4" />    
    <table class="table dataTable">
        <thead class="thead-dark">
            <tr>
                <th width="100">#</th>
                <th>Name</th>
                <th>supply Rate Broiler</th>
                <th>Live rate Broiler</th>
                <th>Chicken rate</th>

                <th>Supply Rate Layer</th>
                <th>Live rate layer</th>
                <th>Supply rate egg</th>
                <th>Paper Rate Egg</th>
                <th>Wholesale Rate Eggs</th>
            </tr>
        </thead>
        <tbody>            
            @foreach($rates as $rate)
            <tr> 
                <td><kbd>#{{ $loop->iteration }}</kbd></td>               
                <td>{{ $rate['Date'] }}</td>
                <td>@convert($rate['supply Rate Broiler']) </td>
                <td>@convert($rate['Live rate Broiler']) </td>
                <td>@convert($rate['Chicken rate']) </td>
                <td>@convert($rate['Supply Rate Layer']) </td>
                <td>@convert($rate['Live rate layer']) </td>
                <td>@convert($rate['Supply rate egg']) </td>
                <td>@convert($rate['Paper Rate Egg']) </td>
                <td>@convert($rate['Wholesale Rate Eggs']) </td>                
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(function(){
            var table = $('table').DataTable();   
        
            table.button().add( 0,[
                {
                    text: 'Add New Rate',
                    className: 'btn btn-primary btn-sm mx-1 rounded',
                    action: function(e, dt, node, config) {
                        $.ajax({
                            url : "{{route('add.rate') }}",
                            dataType: 'json',
                            cache : false,
                            processData: false,
                            success:function(res){
                                $("#dynamicModal").html(res);         
                                $("#dynamicModal").modal("show");
                            }
                        }).done(function(response) {
                            alert(response);
                        });
                    }
                }
            ]);
        });
    </script>

</x-cps-layout>
