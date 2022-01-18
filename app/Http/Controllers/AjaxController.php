<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function index(){
        if(isset($_POST['category_Id'])){
            $id=$_POST['category_Id'];
            $subcat=Subcategory::where('category_id',$id)->get();
            echo "<option value=''>Select Subcategory</option>";
            foreach($subcat as $sc){
                echo "<option value='$sc->id'>$sc->name</option>";
            }
        }
    }
}
