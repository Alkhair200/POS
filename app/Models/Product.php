<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{

    use Translatable;

    use HasFactory;

    protected $guarded = [];

    public $translatedAttributes = ['name' , 'description'];

    protected $appends =['image_path' , 'profit_percent'];

    public function category()
    {
        return $this->belongsTo(Category::class);
        
    }// end of category


    public function orders()
    {
        return $this->belongsToMany(Order::class , 'product_order');

    }// end of orders


    public function getImagePathAttribute(){

        return asset('images/product_images/' .$this->image);

    }// end get image path

    public function getProfitPercentAttribute()
    {
        $profit = $this->sale_price - $this->purchase_price;

        $profit_percent = $profit * 100 / $this->purchase_price;
        return number_format($profit_percent);

    }// end of profit percent

}// end of model
