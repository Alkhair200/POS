<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = ['product one' , 'product tow'];

        foreach ($products as $product) {
            
            Product::create([

                'category_id' => 1,
                'ar' => ['name' => $product, 'description' =>$product. 'desc'],
                'en' => ['name' => $product, 'description' =>$product. 'desc'],
                'purchase_price' => 150,
                'sale_price' => 300,
                'stock' =>20,


            ]);

        }// end of foreach
    }
}
