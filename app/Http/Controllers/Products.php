<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use SettingGroup;

class Products extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::all();        
        return view('pages.products.main',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $weightUnits = SettingGroup::where('group','Weight Unit')->first();        
        return view('pages.products.create',compact('weightUnits'));
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
        if($request->file("product_image")){
            // add new file
            $name = time().'_'.$request->file('product_image')->getClientOriginalName();
            $filePath = $request->file('product_image')->storeAs('products', $name, 'public');
            $request->request->add(["image" => '/storage/'.$filePath ]);
        }
        Product::create($request->all());
        return redirect()->route('product.index');
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
        $weightUnits = SettingGroup::where('group','Weight Unit')->first();
        $product = Product::find($id);
        return view('pages.products.edit',compact('product','weightUnits'));
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
        $product = Product::find($id);
        if($request->file("product_image")){
            // remove existing file 
            if(!empty($product->image))
                unlink(public_path($product->image));
            // add new file
            $name = time().'_'.$request->file('product_image')->getClientOriginalName();
            $filePath = $request->file('product_image')->storeAs('products', $name, 'public');
            $request->request->add(["image" => '/storage/'.$filePath ]);
        }
        //        
        $product->update($request->all());
        return redirect()->route('product.index');
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
        $product = Product::find($id);
        $shops = $product->shops()->detach();
        $product->delete();
        // 
        return back();
    }
}
