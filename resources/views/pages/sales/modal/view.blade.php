<div class="modal-dialog" style="width: 65% !important;max-width: 65%;">
  <div class="modal-content">  
    @if(empty($list))
    <div class="modal-body p-0">  
      <div class="alert alert-warning m-0" role="alert">
        No sale found for today of {{ $title }}.
      </div>
    </div>
     @else  
    <div class="modal-body p-0">
      <h5 class="modal-title d-inline-flex p-1" id="exampleModalLabel">{{ $title }}</h5>
      <button type="button" class="close p-1" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>     
      <table class="table table-sm table-striped table-hover text-center dataTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Weight (kg) </th>
                <th>Rate</th>
                <th>Amount</th>
        </tr>
        </thead>
        <tbody>                        
            @forelse($list as $data)
                <tr>
                    <td><kbd>{{ $data['ID'] }}</kbd></td>
                    <td>{{ $data['Date'] }}</td>
                    <td>{{ $data['Weight (kg)'] }}</td>
                    <td>@convert($data['Rate'])</td>
                    <td>@convert($data['Amount'])</td>
                </tr>
                @if($loop->last)
                <tr class="bg-info font-weight-bold">
                    <td colspan="2" class="font-weight-bold">Total</td>
                    <td>@weight($collect->sum('Weight (kg)'))</td>
                    <td></td>
                    <td>@convert($collect->sum('Amount'))</td>                
                </tr>
                @endif
            @empty
                <tr>
                    <td colspan="4" class="text-center">No Record Found</td>
                </tr>
            @endforelse
        </tbody>
      </table>           
    </div>
    <div class="modal-footer">   
      <form action="{{ route('sales.update',1) }}" method="POST">
        @csrf 
        @method('PATCH')        
        <input type="hidden" name="{{$field1}}" value="{{ $collect->sum('Weight (kg)') }}" />
        <input type="hidden" name="{{$field2}}" value="{{ $collect->sum('Amount') }}" />
        <input type="hidden" name="date" value="{{ $rate['id'] }}" />
        <button type="submit" class="btn btn-primary">Merge all sale to Bhuvan Sale</button>
      </form>        
    </div>
    @endif    
  </div>
</div>