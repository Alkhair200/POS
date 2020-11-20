<?php

namespace App\Models;

use App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

     
    protected $casts = [
        'phone' => 'array'
    ];

    public function getNameAttribute($val)
    {
        return ucfirst($val);

    }// end of getNameAttribute


    public function orders()
    {
        return $this->hasMany(Order::class);

    }//end of orders

}// end of casts
