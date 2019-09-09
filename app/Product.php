<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['name','description','image_id','category_id','price','market_id',];
    protected $hidden = [
        'image_id', 'category_id','market_id',
    ];
    public function market()
    {
        return $this->belongsTo('App\Market');
    }
    public function category(){
        return $this->hasOne('App\Category');
    }
    public function image(){
        return $this->morphOne('App\Image','imageable');
    }
    
}
