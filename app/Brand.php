<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable =[
        "title","title_ar", "image", "parent_id","notes","is_active"
    ];

    public function product()
    {
    	return $this->hasMany('App/Product');
    }
}
