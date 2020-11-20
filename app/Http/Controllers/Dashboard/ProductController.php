<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;

use Storage;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    
    public function index(Request $request)
    {
     
        $categories = Category::all();
        $products = Product::when($request->search , function($q) use($request){

            return $q->whereTranslationLike('name' , '%' .$request->search. '%');

        })->when($request->category_id , function($q) use($request){

            return $q->where('category_id' , $request->category_id);

        })->latest()->paginate(PAGINATION_COUNT);

        return view('dashboard.products.index',compact('categories','products'));

    }// end of index



    public function create()
    {
        $categories = Category::all();

        return view('dashboard.products.create',compact('categories'));

    }// end of create



    public function store(Request $request)
    {
    
        
        $rules = [
            'category_id' => 'required'
        ];

        foreach (config('translatable.locales') as $loacle) {
            
            $rules += [$loacle. '.name' => 'required|unique:product_translations,name'];
            $rules += [$loacle. '.description' => 'required'];

        }// end of foreach

        $rules += [
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];

        $request->validate($rules);

        // dd($request);


        $request_data = $request->all();

        if ($request->image) {
            
            SaveImage('images/product_images/' , $request->image);

            $request_data['image'] = $request->image->hashName();

        }// end of if


         Product::create($request_data);

         session()->flash('success' , __('site.added_successfully'));
         return redirect()->route('dashboard.products.index');

    }// end of store


    
    // public function show(Product $product)
    // {
    //     //
    // }




    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit',compact('categories','product'));

    }// end of edit


    

    public function update(Request $request, Product $product)
    {
        
        $rules = [
            'category_id' => 'required'
        ];

        foreach (config('translatable.locales') as $loacle) {
            
            $rules += [$loacle. '.name' => 'required' , Rule::unique('product_translations' ,'name')->ignore($product->id , 'product_id')];
            $rules += [$loacle. '.description' => 'required'];

        }// end of foreach

        $rules += [
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];

        $request->validate($rules);

        $request_data = $request->all();
        
        if ($request->image) {

            if ($product != 'product.png') {
                
                Storage::disk('public_images')->delete('/product_images/' .$product->image);

            }// end inner if

            SaveImage('images/product_images/' , $request->image);

                $request_data['image'] = $request->image->hashName();
        
        }// end external if

        $product->update($request_data);

        session()->flash('success' , __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');

    }// end of update




    public function destroy(Product $product)
    {

        Storage::disk('public_images')->delete('/product_images/' .$product->image);
        
        $product->delete();

        session()->flash('success' , __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }
}
