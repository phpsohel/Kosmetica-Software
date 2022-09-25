<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id', "customer_id","date","ratings","comment"
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }


}
