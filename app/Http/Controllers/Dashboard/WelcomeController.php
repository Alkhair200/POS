<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {

        $products_count = Product::count();
        $categories_count = Category::count();
        $clients_count = Client::count();
        $orders_count = Order::count();
        $users_count = User::count();
        return view('dashboard.welcome' , 
        compact('products_count','categories_count','clients_count','orders_count','users_count'));

    }// end of endex
    
}// end of controller
