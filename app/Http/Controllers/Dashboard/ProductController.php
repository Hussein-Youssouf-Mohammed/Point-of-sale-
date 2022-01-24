<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule as ValidationRule;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $products   = Product::when($request->search, function($q) use ($request){
            return $q->whereTranslationLike('name',  '%' . $request->search . '%');
        })->when($request->category_id, function($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        })->latest()->paginate(5);

        return view('dashboard.products.index', compact('categories', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $rules = [
            'category_id' => 'required'
        ];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => 'required|unique:product_translations,name'];
            $rules += [$locale . '.description' => 'required'];

        }//end of  for each

        $rules += [
            'price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];


        $request->validate($rules);

        
        $data = $request->except(['image']);

            $image  = $request->image->store('uploads/products');
            $data['image'] = $image;

        Product::create($data);
         session()->flash('success', __('site.added_successfully'));
         return redirect(route('dashboard.products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        
        $rules = [
            'category_id' => 'required'
        ];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => 'required', ValidationRule::unique('product_translations', 'name')->ignore('product_id', $product->id)];
            $rules += [$locale . '.description' => 'required'];

        }//end of  for each

        $rules += [
            'price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];


        $request->validate($rules);
        $data = $request->except(['image']);
        
        if($request->hasFile('image')) {            
            $image  = $request->image->store('uploads/products');
            $data['image'] = $image;
            Storage::delete($product->image);
        }

        $product->update($data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect(route('dashboard.products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->image == $product->image) {
            Storage::delete($product->image);
        }
        $product->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect(route('dashboard.products.index'));
    }
}
