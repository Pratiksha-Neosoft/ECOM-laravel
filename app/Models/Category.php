<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subcategory;
class Category extends Model
{
    use HasFactory;
    protected $fillable=[
        'category_name',
        'category_slug'
    ];
    public function Product(){
        return $this->belongsToMany(Product::class,'product_categories','categories_id','products_id');
    }
}
