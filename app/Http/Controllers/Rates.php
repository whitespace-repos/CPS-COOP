<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rate;
use Product;
use Carbon;
use Inertia;
use ProductWholesaleRateRange;

class Rates extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rates = Rate::where( 'date', Carbon::today())
                        ->with('product.weightRanges')
                        ->where('status','Active')
                        ->get();
        $products = Product::all();
        $product = empty($products) ? [] : Product::with('shops','weightRanges')->first();
        if($products->count() == 0){
            return Inertia::render('Dependecy', ["message" => "You need to create atleast one product for accessing <b> Rate </b> feature"]);
        }
        return Inertia::render('Rate/Rates', ["products" => $products ,"selectedProduct" => $product , "rates" => $rates ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $products = Product::all();
        return view('pages.rates.create',compact('products'));
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
        $product = Product::find($request->product_id);
        //
        $productTodayRate = Rate::where( 'date', Carbon::today())
                        ->where('status','Active')
                        ->where('product_id',$product->id)
                        ->first();
        if(!empty($productTodayRate)){
            $productTodayRate->status = 'Inactive';
            $productTodayRate->save();
        }
        //
        $request->request->add(['date' => Carbon::today()]);
        $rate = Rate::create($request->all());


        // Save Whole weight Range Rate
        $wholesaleRangeRates = collect();

        if($product->wholesale_weight_range){
            foreach($product->weightRanges as $key => $range){
                $range->wholesale_rate = (empty($request->range["range-".$range->id])) ? 0 : $request->range["range-".$range->id];
                $range->save();
                $wholesaleRangeRates->push([
                                    "from" => $range->from,
                                    "to" => $range->to,
                                    "product_id" => $range->product_id,
                                    "id" => $range->id,
                                    "rate" => (empty($request->range["range-".$range->id])) ? 0 : $request->range["range-".$range->id],
                ]);
            }
        }else{
            $wholesaleRangeRates->push([
                            "from" => $product->default_wholesale_weight,
                            "to" => 50000,
                            "product_id" => $product->id,
                            "rate" => (empty($request->default_wholesale_weight)) ? 0 : $request->default_wholesale_weight,
            ]);
        }


        $rate->wholesale_rate =  $wholesaleRangeRates->toJson();
        $rate->save();

        return redirect()->route('rate.index');
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
        $rates = Rate::where( 'date', Carbon::today())
                                ->with('product.weightRanges')
                                ->where('status','Active')
                                ->get();
        $products = Product::all();
        $product = Product::where('id',$id)->with('shops','weightRanges')->first();
        return Inertia::render('Rate/Rates', ["products"=> $products , "selectedProduct" => $product , "rates" => $rates ]);
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
        $rate = Rate::with('product.weightRanges')->where("id",$id)->first();
        return response()->json($rate);
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
            \Log::info($id);
            \Log::info($request);

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

    //
    public function getRate(Request $request){
        $rates = Rate::with('product.weightRanges')
                                ->where('date',$request->date)
                                ->get();
        return Inertia::render('Rate/Rates', ["rates" => $rates ]);
    }
}
