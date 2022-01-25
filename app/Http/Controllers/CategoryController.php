<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $categories=Category::all();
        return view('admin.categories.view_categories',compact('categories'));
    }
    public function addCategory(){
        return view('admin.categories.add_category');
    }
    public function insertCategory(Request $req){
        $validated=$req->validate([
            'category_name'=>'required',
            'category_slug'=>'required|unique:categories',
        ]);
        if($validated){
            $category=new Category();
            $category->category_name=$req->category_name;
            $category->category_slug=$req->category_slug;
            $category->save();
            return redirect('admin/category');
        }
    }
    public function updateCat($cat_slug){
        $cat=Category::where('category_slug',$cat_slug)->first();
        return view('admin.categories.update_category',compact('cat'));
    }
    public function postupdatecat(Request $req,$cat_slug){
        $validated=$req->validate([
            'category_name'=>'required',
            'category_slug'=>'required',
        ],[
            'category_name.required'=>'The category name field is required.',
            'category_slug.required'=>'The category slug field is required.',
        ]);
        if($validated){

            $cat=Category::where('category_slug',$cat_slug)->first();
            $cat->category_name=$req->category_name;
            if($cat->category_slug!=$req->category_slug){
                $slugval=$req->validate([
                    'category_slug'=>'unique:categories'
                ]);
                if($slugval){
                    $cat->category_slug=$req->category_slug;
                }
            }
            if($cat->save()){
                return redirect("admin/category");
            }

        }

    }
    public function deleteCat($cat_slug){
        $category=Category::where('category_slug',$cat_slug)->first();
        $cat_id=$category->id;
        if($category->delete()){
            $prods=Product::where('category_id',$cat_id)->get();
            foreach($prods as $p){
                $p->delete();
            }
        return redirect('admin/category');

        }
    }
    
}