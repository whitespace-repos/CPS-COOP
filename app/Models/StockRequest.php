<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    use HasFactory;

    protected $fillable = [
                            'product_id',
                            'shop_id',
                            'stock_request',
                            'stock_remaining',
                            'payment_method',
                            'payment_period',
                            'stock_requested_by',
                            'status',
    ];


    public function product(){
        return $this->belongsTo('Product');
    }


    public function shop(){
        return $this->belongsTo('Shop');
    }


    public function stockRequestedBy(){
        return $this->belongsTo('User','stock_requested_by');
    }
}
