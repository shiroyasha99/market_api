<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable = ['imageable_type','imageable_id','name','path','url',];
    protected $hidden = [
        'imageable_type', 'imageable_id','path',
    ];
    public function products()
    {
        return $this->morphTo('App\Product','imageable');
    }
    public function market(){
        return $this->morphTo('App\Image','imageable');
    }
}
