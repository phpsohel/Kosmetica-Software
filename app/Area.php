<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable =[

        "name","hub_id", "phone", "email", "address", "is_active"
    ];


}
