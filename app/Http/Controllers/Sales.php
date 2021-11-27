<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Airtable;
use App\Http\Traits\CPSTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Sales extends Controller
{
    use CPSTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sales = $this->getList("Bhuvan Sales"); 
        return view('pages.sales.main')->with([
                                                                    "sales" => empty($sales) ? [] : collect($sales)->pluck('fields'),
                                                                    "dispalyDate" => function($table,$id){
                                                                        return $this->getRecordDate($table,$id);
                                                                    }
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $rate = $this->getTodayRates();
        $list = $this->getList('Broiler Live Sales',5,'ID'); 
        return view('pages.sales.create')->with([
                                                    "rate" => empty($rate) ? [] : collect($rate)->pluck('fields')->first(),
                                                    "list" => empty($list) ? [] : collect($list)->pluck('fields') ,
                                                    "customerSales" => []                                                  
                                        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        //     

        $arr = $request->except(['date','_token','_method']);
        $data = [];
        // 
        foreach($arr as $key => $ar){
            $k = Str::replace('_', ' ', $key);
            $data += [ $k => (float) $ar];        
        }
        //   
        $rateSale = $this->getRecord('Bhuvan Sales',$request->date);                 
        $checkSaleRecord = collect($rateSale['fields']); 

        if(Arr::exists($checkSaleRecord, 'Shop1 Sales')){
            Log::info("Update Record");            
            $saleRecordId = $checkSaleRecord->get('Shop1 Sales')[0];   
            Log::info($saleRecordId);
            Log::info($data);         
            $this->patchRecord("Bhuvan Sales",$data, $saleRecordId);
        }else {
            $initialData = [
                        "Date" =>[$request->date],
                        "Sales retail Live (Kg)" => (float) 0 ,
                        "Sales Wholesale Live (Kg)" => (float) 0,
                        "Amount wholesale Live" => (float)  0,
                        "Sales wholesale chicken (Kg)" => (float) 0,
                        "Amount wholesale chicken" => (float) 0,
                        "Convertion Rate" => (float) 0,
                        "Sales retail layer (Kg)" => (float) 0,
                        "Sales wholesale layer (Kg)" => (float) 0,
                        "Amount wholesale layer" => (float) 0,
                        "Sales Eggs (Nr)" => (float) 0
            ];
            $record = $this->saveRecord('Bhuvan Sales',$initialData);  
            $saleRecordId = collect($record->collect()['records'])->pluck('id');      
            $this->patchRecord("Bhuvan Sales",$data, $saleRecordId);                  
        }         
        return redirect()->route('sales.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function load_current_sales_tab($table){
        $rate = $this->getTodayRates();
        $view = "";
        // 
        if($table == "Broiler Live Sales")
            $view = "pages.sales.ajax.broilerLive";
        elseif($table == "Broiler Chicken Sales")
            $view = "pages.sales.ajax.broilerChicken";
        elseif($table == "Layer Sales")
            $view = "pages.sales.ajax.liveRatelayer";        
        elseif($table == "Egg Sales")
            $view = "pages.sales.ajax.eggSale";
        // 

        $list = $this->getList($table,5,'ID');       
        return view($view)->with([
                                                    "rate" => empty($rate) ? [] : collect($rate)->pluck('fields')->first(),
                                                    "list" => empty($list) ? [] : collect($list)->pluck('fields')                                                   
                                        ]);
    }

    /**
     * Broiler Live
     */

    public function broiler_live(Request $request){  
        if(empty($request->customer)){            
            $customerDetail = [
                        "Phone" => $request->Phone,                        
                        "Name" =>  $request->Name,                       
                        "Email" => $request->Email,
            ];            
            $this->saveRecord('Customers',$customerDetail);
        }
        
        $data = [
                    "Date" => $request->date,
                    "Weight (kg)" => (float) $request->weight,
                    "Rate" => (float) $request->rate,
                    "Amount" => (float) sprintf('%.2f',($request->weight * $request->rate)),
                    "Customer" => (string) $request->Phone,
                    "Receive" => (float) $request->receive,                    
        ];
        $response = $this->saveRecord('Broiler Live Sales',$data);
        // 
        $data += ["Product" =>(string)  "Broiler Live"];
        if($response->successful()){
            // 
            if($request->has('addToCart')){
                if ($request->session()->exists($request->Phone)) {
                    $request->session()->put('cart',[]);                    
                }
                $request->session()->push('cart',$data);
            }

            
            $rate = $this->getTodayRates();
            $list = $this->getList('Broiler Live Sales',5,'ID'); 
             
            return view('pages.sales.ajax.broilerLive')->with([
                                                        "rate" => empty($rate) ? [] : collect($rate)->pluck('fields')->first(),
                                                        "list" => empty($list) ? [] : collect($list)->pluck('fields'),
                                                        "customerSales" => empty($customerSales) ? [] : collect($customerSales)->pluck('fields'),                                                  
                                            ]);
        }        
    }


    public function broiler_chicken(Request $request){
        if(empty($request->customer)){            
            $customerDetail = [
                        "Phone" => $request->Phone,                        
                        "Name" =>  $request->Name,                       
                        "Email" => $request->Email,
            ];            
            $this->saveRecord('Customers',$customerDetail);
        }

        $data = [
                    "Date" => $request->date,
                    "Weight (kg)" => (float) $request->weight,
                    "Rate" => (float) $request->rate,
                    "Amount" => (float) sprintf('%.2f',($request->weight * $request->rate)),
                    "Customer" => (string) $request->Phone,
                    "Receive" => (float) $request->receive,
                    "Convertion Rate" => (float) 0.80,                    
        ];
        $response = $this->saveRecord('Broiler Chicken Sales',$data);
        $data += ["Product" =>(string)  "Broiler Chicken"];
        // 
        if($response->successful()){
            if($request->has('addToCart')){
                if ($request->session()->exists($request->Phone)) {
                    $request->session()->put('cart',[]);                    
                }
                $request->session()->push('cart',$data);
            }


            $rate = $this->getTodayRates();
            $list = $this->getList('Broiler Chicken Sales',5,'ID');  
            return view('pages.sales.ajax.broilerChicken')->with([
                                                        "rate" => empty($rate) ? [] : collect($rate)->pluck('fields')->first(),
                                                        "list" => empty($list) ? [] : collect($list)->pluck('fields'),
                                                        "customerSales" => empty($customerSales) ? [] : collect($customerSales)->pluck('fields'),                                                                                                     
                                            ]);
        }        
    }



    public function layers_sales(Request $request){
        if(empty($request->customer)){            
            $customerDetail = [
                        "Phone" => $request->Phone,                        
                        "Name" =>  $request->Name,                       
                        "Email" => $request->Email,
            ];            
            $this->saveRecord('Customers',$customerDetail);
        }

        $data = [
                    "Date" => $request->date,
                    "Weight (kg)" => (float) $request->weight,
                    "Rate" => (float) $request->rate,
                    "Amount" => (float) sprintf('%.2f',($request->weight * $request->rate)),
                    "Customer" => (string) $request->Phone,
                    "Receive" => (float) $request->receive,
                    
        ];
        $response = $this->saveRecord('Layer Sales',$data);
        $data += ["Product" =>(string)  "Layer"];
        // 
        if($response->successful()){
            if($request->has('addToCart')){
                if ($request->session()->exists($request->Phone)) {
                    $request->session()->put('cart',[]);                    
                }
                $request->session()->push('cart',$data);
            }

            $rate = $this->getTodayRates();
            $list = $this->getList('Layer Sales',5,'ID');  
            return view('pages.sales.ajax.liveRatelayer')->with([
                                                        "rate" => empty($rate) ? [] : collect($rate)->pluck('fields')->first(),
                                                        "list" => empty($list) ? [] : collect($list)->pluck('fields') ,
                                                        "customerSales" =>  [],                                                                                                                                                       
                                            ]);
        }        
    }



    public function egg_sales(Request $request){
        if(empty($request->customer)){            
            $customerDetail = [
                        "Phone" => $request->Phone,                        
                        "Name" =>  $request->Name,                       
                        "Email" => $request->Email,
            ];            
            $this->saveRecord('Customers',$customerDetail);
        }
        
        $data = [
                    "Date" => $request->date,
                    "Weight (kg)" => (float) $request->weight,
                    "Rate" => (float) $request->rate,
                    "Amount" => (float) sprintf('%.2f',($request->weight * $request->rate)),
                    "Customer" => (string) $request->Phone,
                    "Receive" => (float) $request->receive,
                    
        ];
        $response = $this->saveRecord('Egg Sales',$data);
        $data += ["Product" =>(string)  "Egg"];
        // 
        if($response->successful()){

            if($request->has('addToCart')){
                if ($request->session()->exists($request->Phone)) {
                    $request->session()->put('cart',[]);                    
                }
                $request->session()->push('cart',$data);
            }

            
            $rate = $this->getTodayRates();
            $list = $this->getList('Egg Sales',5,'ID');  
            return view('pages.sales.ajax.eggSale')->with([
                                                        "rate" => empty($rate) ? [] : collect($rate)->pluck('fields')->first(),
                                                        "list" => empty($list) ? [] : collect($list)->pluck('fields') ,
                                                        "customerSales" =>  [],                                              
                                            ]);
        }        
    }


    public function view_all_sales_data(Request $request){
        // 
        $rate = $this->getTodayRates();        
        $list = $this->getDataOfToday($request->table);  
        if($request->table == "Broiler Live Sales"){
            $field1 = "Sales retail Live (Kg)";
            $field2 = "Amount wholesale Live";
        }else if($request->table == "Broiler Chicken Sales"){
            $field1 = "Sales wholesale chicken (Kg)";
            $field2 = "Amount wholesale chicken";
        }else if($request->table == "Layer Sales"){
            $field1 = "Sales retail layer (Kg)";
            $field2 = "Amount wholesale layer";
        }else if($request->table == "Egg Sales"){
            $field1 = "Sales Eggs (Nr)";            
            $field2 = "";
        }

        return view('pages.sales.modal.view',compact('field1','field2'))->with([
                                                        "rate" => empty($rate) ? [] : collect($rate[0]),
                                                        "list" => empty($list) ? [] : collect($list)->pluck('fields'),
                                                        'title' => $request->table,
                                                        'collect' => collect(collect($list)->pluck('fields'))
        ]);
    }


    public function getCustomerByPhone(Request $request){
        $customer = $this->getCustomerByPhoneNumber($request->phone);
        $customerSales = $this->getCustomerSalesList($request->table,$request->phone,5,"ID","desc");
        if(empty($customer))
            return response()->json(null);
        else 
            return response()->json([ 
                                        "customer" => $customer ,
                                        "customerSales" => $customerSales
                ]);
    }
}
