<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    //
    protected $fillable = ['name','address','image_id','phone','longtude','latitude',];
    protected $hidden = [
        'image_id',
    ];
    public function products()
    {
        return $this->hasMany('App\Product');
    }
    public function image(){
        return $this->morphOne('App\Image','imageable');
    }
}
