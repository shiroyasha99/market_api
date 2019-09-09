<?php

namespace App\Http\Controllers;
use Validator;
use App\Product;
use App\Market;
use App\Category;
use App\Image;
use Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
        $messages = [
            'image_name.required' => 'The Image name is required',
            'image_base64.required' => 'The Image is required .',
            'name.required'=>'Market name is required .',
            'description.required'=>'Product description is required .',
            'category_id.required'=>'Product Category is required .',
            'price.required'=>'Product Price is required .',
            'market_id.required'=>'Market name is required .'
        ];
        $rules = [
            'name' => 'required',
            'image_name' => 'required',
            'image_base64' => 'required',
            'description'=>'required',
            'category_id'=>'required',
            'price'=>'required',
            'market_id'=>'required'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            $res = $validator->messages();
            return $res->toJson();
        }else{
        $image_name = $request->image_name;
        $image_base64 = $request->image_base64;
        $image_ext = explode('.',$image_name);
        $image_ext = $image_ext[sizeof($image_ext)-1];
        $time = time();
        $image_path = $image_name.'_'.$time.'.'.$image_ext;
        Storage::put("/product_files/images/".$image_path,base64_decode($image_base64));
        $info = [
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price
            ];
        $product = Product::create($info);
        $image_url = route('product_image_route',$product->id);
        $image = Image::create(['name'=>$image_name,'path'=>$image_path,'url'=>$image_url]);
        $product->image()->save($image);
        $cat = Category::find($request->category_id);
        $cat->products()->save($product);
        $market = Market::find($request->market_id);
        $market->products()->save($product);
        return $product;
        }
    }
    public function down_image($id)
    {
        # code...
        $product = Product::find($id);
        if($product != null)
        {
            if(Storage::exists('product_files/images//'.$product->image->path)){
                return response()->download(storage_path("app/product_files/images/".$product->image->path),$product->image->name);   
                }else{
                    return response()->json(['error'=>'file not exist .'], 404);
                }
        }else{
            return response()->json(['status'=>'error','error'=>'Book not exist'], 404);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
        $product = Product::find($id);
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
    }
}
