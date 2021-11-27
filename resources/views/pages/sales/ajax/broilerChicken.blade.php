@if(!empty($rate))
<div class="container-fluid" id="bchicken">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-success my-4">
                <form class="" id="" action="{{ route('broiler.chicken.sales') }}" method="POST">   
                    @csrf  
                    <div class="card-header bg-transparent border-success">
                        Broiler Chicken
                        <input type="hidden" name="rate" id="bchicken_rate" value="{{ $rate['Chicken rate'] }} "/>
                        <input type="hidden" name="date" value="{{ $rate['Date'] }} "/>
                        <input type="hidden" name="customer" id="bchicken_customer" />
                        <small class="float-end font-weight-bold text-danger"> @convert($rate['Chicken rate']) </small>
                    </div>
                    <div class="card-body text-success">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="text-semibold">Phone</label>
                                    <input name="Phone"  class="form-control phone_us" />
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="text-semibold">Name</label>
                                    <input name="Name" id="customer_name" class="form-control" disabled/>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="text-semibold">Email</label>
                                    <input name="Email" id="customer_email" class="form-control" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="bchicken_weight" class="form-label">Weight</label>
                            <input  type="number" name="weight" class="form-control" id="bchicken_weight" aria-describedby="bchicken_weightHelp">
                            <div id="bchicken_weightHelp" class="form-text">Weight will be calculated in kg . ( weight * rate / convertion rate )</div>
                        </div>   
                        <div class="row">
                            <div class="col">
                                <label for="bchicken_totalCost" class="form-label w-100">Total cost <span class="text-danger font-weight-bold float-right mt-1" style="font-size:12px">C/R : 0.80</span></label>
                                <input  name="amount" class="form-control" disabled readonly id="bchicken_totalCost" aria-describedby="bchicken_costHelp" />                            
                            </div>
                            <div class="col">
                                <label for="bchicken_totalCost" class="form-label w-100">Receive cost <span class="text-danger font-weight-bold float-right mt-1"  style="font-size:12px">C/R : 0.80</span></label>
                                <input name="receive" class="form-control" id="bchicken_receiveCost"/>                                
                            </div>
                            <div id="bchicken_costHelp" class="form-text mb-4">Cost will be calculated in {{ config('airtable.currency')}} .</div>                            
                        </div>    
                        <label><input type="checkbox" name="addToCart" value="1" /> Add To Cart </label>                                
                        <button type="submit" class="btn btn-primary">Save Sale</button>                                    
                    </div>  
                    
                    <div class="card-body text-success p-0">                                  
                        <table class="table table-sm table-striped table-hover text-center mb-0" style="display:none">
                            <thead>
                                <tr>
                                    <th>Phone</th>
                                    <th>Date</th>
                                    <th>Weight (kg)</th>
                                    <th>Rate</th>
                                    <th>Receive</th>
                                    <th>Amount</th>                                    
                            </tr>
                            </thead>
                            <tbody id="customerDetail"></tbody>
                        </table>                       
                    </div>  
                    <!-- <div class="card-footer bg-transparent border-success">Footer</div> -->
                </form>                                
            </div>
        </div>
        <div class="col-md-5">
            <div class="card border-success my-4">
                <div class="card-header bg-transparent border-success">
                    Rcent Five Sale Detail 
                    <small class="float-end font-weight-bold text-danger"> <i data-feather="shopping-cart"></i> @if (session('cart')) {{ count(session('cart')) }} @else {{ 0 }} @endif </small>
                </div>
                <div class="card-body text-success p-0">                                  
                    <table class="table table-sm table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Weight (kg) </th>
                                <th>Rate</th>
                                <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>                        
                            @forelse($list as $data)
                                <tr>
                                    <td>{{ $data['Date'] }}</td>
                                    <td>{{ $data['Weight (kg)'] }}</td>
                                    <td>@convert($data['Rate'])</td>
                                    <td>@convert($data['Amount'])</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Record Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>  
                    <!--  -->
                    <a href="{{ route('view.all.sales.data').'?table=Broiler Chicken Sales' }}" class="dynamicModal btn btn-secondary m-2 float-end"> Close Today Sale of  Broiler Chicken</a>
                </div>                              
            </div>
        </div>
    </div>
</div>

<script>
        $(document).ready(function(){  
            // 
            $("#bchicken_weight").on("keyup",function(){
                $rate = $("#bchicken_rate").val();
                $weight = $("#bchicken_weight").val();
                if($weight != "" && $weight != null){
                    $cost = parseFloat($rate) * parseFloat($weight) / parseFloat(0.80);                    
                    $("#bchicken_totalCost").val($cost);
                }
            });   

            $("#bchicken form").on("submit",function(e){
                e.preventDefault();
                $form = $(this);
                // 
                $.post($form.attr('action'), $form.serialize(), function(response) {
                    $("#response-container").html(response);	
                    feather.replace();                          
                });
            });


            $('.phone_us').mask('(000) 000-0000',{
                onComplete: function(phone) {
                    $.ajax({
                        url:"{{ url('sale/get/customer') }}",
                        dataType:'json',
                        data:{phone:phone,table:'Broiler Chicken Sales'},
                        beforeSend:function(){$.blockUI()},
                        completed:function(){$.unblockUI()},
                        success:function(res){
                            console.log(res);
                            if(_.size(res.customer)){
                                $customer = _.head(res.customer);
                                $("#customer_name").val($customer.fields.Name).attr("disabled","disabled");
                                $("#customer_email").val($customer.fields.Email).attr("disabled","disabled");
                                $("#bchicken_customer").val($customer.id);
                                if(_.size(res.customerSales)){
                                    var tbody = "";
                                    console.log(res.customerSales);
                                    $(res.customerSales).each(function(i,v){                                        
                                        tbody += "<tr> <td>"+_.get(v.fields,'Customer')+"</td>" +
                                                 "<td>"+_.get(v.fields,'Date')+"</td> " +
                                                 "<td>"+_.get(v.fields,'Weight (kg)')+"</td> " +
                                                 "<td>"+_.get(v.fields,'Rate')+"</td> " +
                                                 "<td>"+_.get(v.fields,'Receive')+"</td> " +
                                                 "<td>"+_.get(v.fields,'Amount')+"</td> </tr>";                                                
                                    });                                    
                                    //
                                    $("#customerDetail").html(tbody);
                                    $("#customerDetail").closest("table").show();
                                }
                            }else{
                                $("#customer_name").val('').removeAttr("disabled");
                                $("#customer_email").val('').removeAttr("disabled");
                                $("#customerDetail").html("");
                                $("#bchicken_customer").val("");
                            }
                        }
                    });
                }
            }); 
        });
    </script>

@else 
<div class="alert alert-danger py-2 my-2" role="alert">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg>
    No Rate found for today. Please contact with administrator    
</div>
@endif
