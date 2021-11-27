<x-cps-layout>
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-tabs-x@1.3.5/css/bootstrap-tabs-x-bs4.min.css" media="all" rel="stylesheet" type="text/css" >
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-tabs-x@1.3.5/js/bootstrap-tabs-x.min.js" type="text/javascript"></script>

    <h4 class="mt-4">Bhuvan Print Preview</h4>   
    
    <hr class="mb-5 mt-4" /> 
     
    <div class="content">
        @if(session('cart'))
            <table class="table table-sm table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>Phone</th>
                        <th>Product</th>
                        <th>Date</th>
                        <th>Weight (kg)</th>
                        <th>Rate</th>
                        <th>Amount</th>
                </tr>
                </thead>
                <tbody>                                       
                    @forelse(session('cart') as $data)
                        <tr>
                            <td>{{ $data['Customer'] }}</td>
                            <td>{{ $data['Product'] }}</td>
                            <td>{{ $data['Date'] }}</td>
                            <td>{{ $data['Weight (kg)'] }}</td>
                            <td>@convert($data['Rate'])</td>
                            <td>@convert($data['Amount'])</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No Record Found</td>
                        </tr>
                    @endforelse
                </tbody>               
            </table>  

            <h4>SMS Text </h4>
            <p> You have purchased {{ count(session('cart')) }} from us. You have to pay @convert(collect(session('cart'))->sum('Amount')).

        @endif
        <hr />
        <button class="btn btn-primary btn-sm"> Print  & Send SMS</button>
        <a href="{{ route('reset') }}" class="btn btn-danger btn-sm "> Reset Bill </a>
        
    </div> 
</x-cps-layout>
