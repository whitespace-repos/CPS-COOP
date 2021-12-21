<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name','status','weight_unit','fields','wholesale_weight','image'];

     /**
     * The shops that belong to the product.
     */
    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }

    /**
     * 
     */
    public function rate(){
        return $this->hasOne(Rate::class)->where( 'date', Carbon::today())->where('status','Active');
    }


    /**
     * product image
     */
    public function getProductImageAttribute(){
        return empty($this->image) ? asset('images/placeholder.png') : asset($this->image);
    }
}
