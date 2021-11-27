<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name','status'];

     /**
     * The shops that belong to the product.
     */
    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }
}
