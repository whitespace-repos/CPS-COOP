<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rate;
use Product;
use Carbon;

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
                        ->where('status','Active')
                        ->get();
        return view('pages.rates.main',compact('rates'));
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
        $productTodayRate = Rate::where( 'date', Carbon::today())
                        ->where('status','Active')
                        ->where('product_id',$request->product_id)
                        ->first();
        if(!empty($productTodayRate)){
            $productTodayRate->status = 'Inactive';
            $productTodayRate->save();
        }        
        // 
        $request->request->add(['date' => Carbon::today()]);        
        Rate::create($request->all());
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
        $products = Product::all();
        $rate = Rate::find($id);
        return view('pages.rates.create',compact('products','rate'));
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
}
