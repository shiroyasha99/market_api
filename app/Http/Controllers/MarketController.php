<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Market;
use App\Product;
use App\Image;
use App\Category;
use Storage;
use Validator;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // //
        // $markets = Market::all()->join('categories','category_id','=','categories.id')->groupBy('categories.name');
        // return $markets;
    }
    public function showall()
    {
        //
        $cat = Category::all();
        foreach($cat as $c)
            {
                foreach($c->markets as $market)
                {
                    foreach($market->products as $product)
                    {
                        $product->image;
                    }
                }

            }
        return $cat;

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
        $messages = [
            'image_name.required' => 'The Image name is required',
            'image_base64.required' => 'The Image is required .',
            'name.required'=>'Market name is required .',
            'address.required'=>'Market address is required .',
            'phone.required'=>'Market Phone is required .',
            'longtude.required'=>'Market Position is required .',
            'latitude.required'=>'Market name is required .'
        ];
        $rules = [
            'name' => 'required',
            'image_name' => 'required',
            'image_base64' => 'required',
            'address'=>'required',
            'phone'=>'required',
            'longtude'=>'required',
            'latitude'=>'required'
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
        Storage::put("/market_files/images/".$image_path,base64_decode($image_base64));
        $info = [
            'name'=>$request->name,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'longtude'=>$request->longtude,
            'latitude'=>$request->latitude
            ];
        $market = Market::create($info);
        $image_url = route('market_image_route',['id'=>$market->id]);
        
        $image = Image::create(['name'=>$image_name,'path'=>$image_path,'url'=>$image_url]);
        $market->image()->save($image);
        return $image_url;    
    }
    }

    public function down_image($id)
    {
        # code...
        $market = Market::find($id);
        if($market != null)
        {
            if(Storage::exists('market_files/images//'.$market->image->path)){
                return response()->download(storage_path("app/market_files/images/".$market->image->path),$market->image->name);   
                }else{
                    return response()->json(['error'=>'file not exist .'], 404);
                }
        }else{
            return response()->json(['status'=>'error','error'=>'Image not exist'], 404);
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
        $market = Market::find($id);
        $market->products;
        foreach($market->products as $product)
            $product->image;
        return $market; 
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
        $market = Market::find($id);
        $market->update($request->all());
        return $market;
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
        $market = Market::find($id);
        $market->delete();
    }
}
