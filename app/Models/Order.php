<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=['user_id','address_id','amount','payment_mode','payment_status','payment_id','transaction_id','coupon_used','status'];
}
