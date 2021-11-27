<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Sales extends Controller
{
    //
    public function make(){
        return view('pages.sales.make');
    }
}
