<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id','total_amount','quantity','user_id','first_name','last_name','email','phone','country','post_code','address1','address2','payment_id','amount'
    ];
}
