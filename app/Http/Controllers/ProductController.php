<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all data
       $product = Product::all();
       return response()->json($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Post data to database
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);
        $product = new Product();
        //image upload
        $product->create_date = date("Y/m/d");
        $product->update_date = date("Y/m/d");
        if($request->hasFile('image')){
            $file  = $request->file('image');
            $allowedFileExtention  = ['pdf','jpg'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention, $allowedFileExtention);
            if($check){
                $name  =time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $product->image = $name;
            }
        }
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // edit 1 item in database
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        $product = Product::find($id);
        $product->image = 'not image';
        //image upload
        if($request->hasFile('image')){
            $file  = $request->file('image');
            $allowedFileExtention  = ['pdf'];
            $extention = $file->getClientOriginalExtension();
            $check = in_array($extention, $allowedFileExtention);
            if($check){
                $name  =time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $product->image = $name;
            }
        }

        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json('product Deleted ok!!!');
    }
}
