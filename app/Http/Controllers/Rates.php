<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Airtable;

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
        
        $rates = Airtable::table('Rate')->get();
        return view('pages.rates.main')->with([
                                                                    "rates" => $rates->pluck('fields')
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
   

        $data = Airtable::table('Rate')->updateOrCreate(
                                                            ["Date" => "2021-10-07"],
                                                            ["fields" => [ 
                                                                        "Date" => "2021-10-07",                                                                                                                            
                                                                        "supply Rate Broiler" => "99",
                                                                        "Live rate Broiler" => "99",
                                                                        "Chicken rate" => "9",
                                                                        "Supply Rate Layer" => "9",
                                                                        "Live rate layer" => "9",
                                                                        "Supply rate egg" => "9",
                                                                        "Paper Rate Egg" => "9",
                                                                        "Wholesale Rate Eggs" => "9",
                                                            ]
                                                    ]); 
                                                    
        dd($data);
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
