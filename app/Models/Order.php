<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function client()
    {
        return $this->belongsTo(Client::class);

    }// end of order


    public function products()
    {
        return $this->belongsToMany(Product::class , 'product_order')->withPivot('quantity');

    }// end of products

}// end of class
