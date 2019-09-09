<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Market;
use App\Image;
use App\Category;

class testSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ['name','description','image_id','category_id','price','market_id',]
        $cat = Category::create(['name'=>'food']);
        $image = Image::create(['name'=>"test.png",'path'=>'market_files/images/test.png']);
        $image2 = Image::create(['name'=>"test.png",'path'=>'market_files/images/test2.png']);
        $market = Market::create(['name'=>'alquds','address'=>'jerusalem','phone'=>"0597857597",'longtude'=>"13.5",'latitude'=>"14.6"]);
        $product = Product::create(['name'=>"testProduct",'description'=>"desc",'category_id'=>$cat->id,'price'=>4,'market_id'=>$market->id]);
        $product->image()->save($image);
        $market->image()->save($image2);
        $market->products()->save($product);
    }
}
