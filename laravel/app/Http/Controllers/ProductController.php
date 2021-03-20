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
        $products = Product::all();
        return  response()->json(["data"=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required|regex:/^\d*(\.\d{2})?$/',
            'weight'=>'required',
            'image'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        $image = $request->file('image');
        $path = "images/products";
        $archive = md5($image->getClientOriginalName().strtotime('now')).".".$image->getClientOriginalExtension();

        $image->move($path, $archive);

        $product = new Product;

        $product->name= $request->name;
        $product->price= $request->price;
        $product->weight= $request->weight;
        $product->image= $archive;

        $product->save();

        return response()->json(['data'=>['message'=>'Produto inserido com sucesso']]);
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
        if(!$product){
            return response()->json([
                'error'   => [
                    'message'=>'Produto não existe'
                ],
            ], 404);
        }
        return response()->json(['data'=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        if (Product::where('id', $id)->exists()) {
            $product = Product::find($id);
            $product->name = $request->name ?  $request->name: $product->name;
            $product->price = $request->price ?  $request->price : $product->price;
            $product->weight = $request->weight ?  $request->weight : $product->weight;
            $result = $product->save();

            return response()->json([
              "message" =>$result
            ], 200);
          } else {
            return response()->json([
              "message" => "Book not found"
            ], 404);
          }
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
        if(!$product) {
            return response()->json([
                'message'   => 'Este produto nao existe',
            ], 404);
        }
        if($product->delete()){
            return response()->json([
                'success' => true,
                'message'   => 'Produto deletado com sucesso',
            ], 404);

        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possivel deletar o produto'
            ], 500);
        }

    }
}
