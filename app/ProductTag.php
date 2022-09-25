<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $fillable =[

         "product_id", "tag_id"
    ];

    public function tag()
    {
    	//return $this->belongsTo('App/Tags');
        return $this->belongsTo(Tags::class, 'tag_id', 'id');
    }
    public function product()
    {
        //return $this->hasMany('App\Product');
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
