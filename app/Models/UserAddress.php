<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $fillable=['user_id','email','fullName','state','city',
    'mobile','pincode','mobile_no','address_type','address'];
}
