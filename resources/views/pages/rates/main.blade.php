<x-app-layout>    

    <div class="container">
        <a href="{{ route('rate.create') }}" class="btn btn-primary btn-sm my-5 px-5">Add Today Rate </a>
        <div class="row">
            @foreach ($rates as $rate)
                <div class="col-sm-4">
                    <div class="card mb-4">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-lg-between">
                            <h6 class="card-title p-3 mb-0">{{ $rate->product->product_name }} <small class="text-muted"> {{ $rate->date }} </small></h6>
                            <a href="{{ route('rate.edit',$rate->id) }}" class="btn btn-sm btn-warning align-self-center">Modify</a> 
                        </div>
                        
                        <table class="table table-striped mb-0 small">
                                <tbody>
                                    <tr>
                                        <th>
                                             Supply Rate
                                        </th>
                                        <td>
                                            <sup>INR </sup> {{ $rate->supply_rate }}
                                        </td>
                                        {{--  --}}
                                        <th>
                                            Wholesale Rate
                                       </th>
                                       <td>
                                            <sup>INR </sup>  {{ $rate->wholesale_rate }}
                                       </td>                                       
                                    </tr>

                                    <tr>
                                        <th>
                                             Retail Rate
                                        </th>
                                        <td>
                                            <sup>INR </sup>  {{ $rate->retail_rate }}
                                        </td>
                                        {{--  --}}
                                        <th>
                                            Other Rate
                                       </th>
                                       <td>
                                            <sup>INR </sup> {{ $rate->other_rate }}
                                       </td>                                       
                                    </tr>
                                </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
