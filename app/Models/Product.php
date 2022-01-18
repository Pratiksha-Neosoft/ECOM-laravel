<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['category_id','product_name','product_color','image','description','price','feature_item'];
    public function ProductImage(){
        return $this->hasMany(Product_image::class,'product_id','id');
    }
    public function attributes(){
    	return $this->hasMany(Product_attributes_assoc::class,'product_id','id');
    }
    public function ProductCategory(){
        return $this->hasOne(ProductCategory::class,'products_id','id');
    }
    public function Category(){
        return $this->belongsToMany(Category::class,'product_categories','products_id','categories_id');
    }

}
