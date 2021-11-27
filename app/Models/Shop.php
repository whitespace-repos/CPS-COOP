<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
                                'shop_name',
                                'shop_id',
                                'address',
                                'distance_from_cps',
                                'shop_dimentions',
                                'stock_capacity_per_day',            
                                'max_sale_estimate_per_day',
                                'estimated_start_date',   
                                'status' ,  
                ];

    /**
     * The products that belong to the shop.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
