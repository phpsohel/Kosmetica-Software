<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    protected $fillable =[

        "hub_name","warehouse_id", "phone", "email", "address", "is_active"
    ];

    public function ware()
    {
        return $this->belongsTo('App\Warehouse');
    }

}
