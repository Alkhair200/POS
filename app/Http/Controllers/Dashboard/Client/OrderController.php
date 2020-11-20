<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Models\Client;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function create(Client $client)
    {

        $orders = $client->orders()->with('products')->paginate(PAGINATION_COUNT);

        $categories = Category::with('products')->get();

    
        return view('dashboard.clients.orders.create',compact( 'client', 'categories' ,'orders'));

    }// end of create


    public function store(Request $request , Client $client)
    {
        
        $this->attach_order($request , $client);

        $request->validate([
            'products' => 'required|array',
        ]);

        

        session()->flash('success' , __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');

    }// end of store


    public function edit(Client $client , Order $order)
    {
     
        $orders = $client->orders()->with('products')->paginate(PAGINATION_COUNT);
        
        $categories = Category::with('products')->get();
        
        return view('dashboard.clients.orders.edit',compact( 'client', 'order', 'categories' ,'orders'));

    }// end of edit



    public function update(Request $request ,Client $client, Order $order)
    {
        $request->validate([
            'products' => 'required|array',
        ]);

        $this->detach_order($order);

        $this->attach_order($request , $client);

        session()->flash('success' , __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
        
    }// end of update




    private function attach_order( $request ,  $client)
    {
        
        $order = $client->orders()->create([]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {
            
            // dd($quantity['quantity']);

            $product = Product::findOrFail($id);

            $total_price += $product->sale_price * $quantity['quantity'];

            $product->update([

                'stock' => $product->stock - $quantity['quantity'],
            ]);

        }// end of foreach

        $order->update([
            'total_price' => $total_price,
        ]);

    }// end of attach order

    private function detach_order($order){

        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity,
            ]);
        }// end of foreach

        $order->delete();

    }// end of detach order

}// end of class
