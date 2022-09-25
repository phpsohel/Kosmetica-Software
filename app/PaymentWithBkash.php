<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentWithBkash extends Model
{
    protected $table = 'payment_with_bkash';

    protected $fillable =[

        "payment_id", "mobile_transaction"
    ];
}
