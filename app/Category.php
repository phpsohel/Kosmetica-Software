<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable =[

        "name", "name_ar", 'image', "parent_id", "is_active"
    ];

    public function product()
    {
    	return $this->hasMany('App\Product');
    }
}
