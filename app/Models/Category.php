<?php

namespace App\Models;

use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{

    use Translatable;

    use HasFactory;

    protected $guarded = [];

    public $translatedAttributes = ['name'];

    
    public function products()
    {
        return $this->hasMany(Product::class);

    }// end of products
    
}// end of model
