<?php

namespace App\Http\Controllers;
use App\Models\Product_attributes_assoc;
use App\Models\Product_image;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\UserAddress;
use App\Models\ProductCategory;
use App\Models\UsedCoupon;
use Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    public function addProduct(Request $request){
		if($request->isMethod('post')){
            $validated=$request->validate([
                'category_id'=>'required',
                'product_name'=>'required',
                'product_color'=>'required',
                'image'=>'required|image',
                'price'=>'required|gt:0'
            ]);
			$data = $request->all();

			$product = new Product;
			$product->category_id = $data['category_id'];
			$product->product_name = $data['product_name'];
			$product->product_color = $data['product_color'];
			if(!empty($data['description'])){
				$product->description = $data['description'];
			}else{
				$product->description = '';	
			}
            if(empty($data['feature_item'])){
                $feature_item='0';
            }else{
                $feature_item='1';
            }
			$product->price = $data['price'];

            if($request->hasFile('image')){
                $f=$request->file('image');
                $name = rand().time().'.'.$f->extension();
                $f->move(public_path('images/products/'),
                 $name);
     				$product->image = $name; 

            }
            $product->feature_item = $feature_item;
			if($product->save()){
            $pro_cat=new ProductCategory();
            $pro_cat->products_id=$product->id;
            $pro_cat->categories_id=$product->category_id;
            if($pro_cat->save()){
			return redirect('admin/view-products');
            }
            }else{
                return redirect()->back()->with('flash_message_err', 'Something Went wrong!!');       
            }
		}
		$categories=Category::all();

		$categories_drop_down = "<option value='' selected disabled>Select</option>";
		foreach($categories as $cat){
			$categories_drop_down .= "<option value='".$cat->id."'>".$cat->category_name."</option>";	
		}
        
		return view('admin.products.add_product')->with(compact('categories_drop_down'));
	}  

	public function editProduct(Request $request,$id=null){
		if($request->isMethod('post')){
			$data = $request->all();
            $validated=$request->validate([
                'category_id'=>'required',
                'product_name'=>'required',
                'product_color'=>'required',
                'image'=>'mimes:jpeg,jpg,png',
                'price'=>'required|gt:0'
            ]);
            if(empty($data['feature_item'])){
                $feature_item='0';
            }else{
                $feature_item='1';
            }

            if($request->hasFile('image')){
                $fileName=$request->file('image');
                $name = rand().time().'.'.$fileName->extension();
                $fileName->move(public_path('images/products/'),
                 $name);            
            }else if(!empty($data['current_image'])){
            	$fileName = $data['current_image'];
            }else{
            	$fileName = '';
            }


            if(empty($data['description'])){
            	$data['description'] = '';
            }


			$update=Product::where(['id'=>$id])->update(['feature_item'=>$feature_item,'category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
				'product_color'=>$data['product_color'],'description'=>$data['description'],'price'=>$data['price'],'image'=>$fileName]);
            if($update){
            $updateCat=ProductCategory::where('categories_id',$data['category_id'])->first();
			return redirect('admin/view-products');
            }
		}

		$productDetails = Product::where(['id'=>$id])->first();
		$categories = Category::all();
		$categories_drop_down = "<option value='' disabled>Select</option>";
		foreach($categories as $cat){
			if($cat->id==$productDetails->category_id){
				$selected = "selected";
			}else{
				$selected = "";
			}
			$categories_drop_down .= "<option value='".$cat->id."' ".$selected.">".$cat->category_name."</option>";
		}

		return view('admin.products.update_product')->with(compact('productDetails','categories_drop_down'));
	} 

	public function deleteProductImage($id){
		// Get Product Image
		$productImage = Product::where('id',$id)->first();

		// Get Product Image Paths
		$image_path = 'images/products';

        if(file_exists($image_path.$productImage->image)){
            unlink($image_path.$productImage->image);
        }

        // Delete Image from Products table
        Product::where(['id'=>$id])->update(['image'=>'']);

        return redirect()->back()->with('flash_message_success', 'Product image has been deleted successfully');
	}
    public function deleteProductAltImage($id=null){

        // Get Product Image
        $productImage = Product_image::where('id',$id)->first();

        // Get Product Image Paths
        $image_path = 'images/products/';
        
        if(file_exists($image_path.$productImage->image)){
            unlink($image_path.$productImage->image);
        }

        Product_image::where(['id'=>$id])->delete();

        return redirect()->back()->with('flash_message_success', 'Product alternate mage has been deleted successfully');
    }
    public function viewProducts(Request $request){
		$products = Product::all();
		foreach($products as $key => $val){
			$category_name = Category::where('id',$val->category_id )->first();
			$products[$key]->category_name = $category_name->category_name;

        }
		return view('admin.products.view_products')->with(compact('products'));
	}

	public function deleteProduct($id ){
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product has been deleted successfully');
    }

    public function deleteAttribute($id = null){
        Product_attributes_assoc::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product Attribute has been deleted successfully');
    }

    public function addAttributes(Request $request, $id=null){
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        $categoryDetails = Category::where(['id'=>$productDetails->category_id])->first();
        $category_name = $categoryDetails->category_name;

        if($request->isMethod('post')){
            $validate=$request->validate([
                'attr_name'=>'required',
                'attr_val'=>'required'
            ],[
                'attr_name.required'=>"The attribute name field is required.",
                'attr_val.required'=>"The attribute value field is required."
            ]);
            $data = $request->all();
            $attr = new Product_attributes_assoc;
                    $attr->product_id = $id;
                    $attr->name= $data['attr_name'];
                    $attr->value= $data['attr_val'];
                    $attr->save();   
                    return redirect('admin/add-attributes/'.$id)->with('flash_message_success', 'Product Attributes has been added successfully');
            }

        
        return view('admin.products.add_attributes')->with(compact('productDetails','category_name'));
    }
    public function editAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data = Product_attributes_assoc::find($request->id);
            $data->name=$request->name;
            $data->value=$request->value;
            $data->save();
            return redirect('admin/add-attributes/'.$id)->with('flash_message_success', 'Product Attributes has been updated successfully');
        }
    }

    public function addImages(Request $request, $id=null){
        $productDetails = Product::where(['id' => $id])->first();
        $categoryDetails = Category::where(['id'=>$productDetails->category_id])->first();
        $category_name = $categoryDetails->category_name;

        if($request->isMethod('post')){
            $validated=$request->validate([
                'image'=>'required',
                'image.*'=>'image'
            ]);
            $data = $request->all();
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                foreach($files as $file){
                    $image = new Product_image;
                    $name = rand().time().'.'.$file->extension();
                $file->move(public_path('images/products'),
                 $name);
                    $image->image = $name;  
                    $image->product_id = $data['product_id'];

                    if(!$image->save()){
                        return error_log($image->save());
                    }
                    
                }   
            }

            return redirect('admin/add-images/'.$id)->with('flash_message_success', 'Product Images has been added successfully');

        }

        $productImages = Product_image::where(['product_id' => $id])->orderBy('id','DESC')->get();

        $title = "Add Images";
        return view('admin.products.add_images')->with(compact('title','productDetails','category_name','productImages'));
    }
    public function viewOrder(){
        $products=[];
        $orderPro=[];
        $orders=DB::table('orders')->join('user_addresses','orders.address_id','=','user_addresses.id')
        ->select('orders.id as oid','orders.coupon_used as used','orders.amount as amount','user_addresses.*','orders.status as status')->get();
        foreach($orders as $o){
            $opdata=OrderProduct::where('order_id',$o->oid)->get();
            foreach($opdata as $op){
                $orderPro[]=Product::where('id',$op->product_id)->first();

            }
            if($o->used=='1'){
                $dis=UsedCoupon::where('order_id',$o->oid)->first();
                $discount=$dis->discounted_price;

            }else{
                $discount=0;
            }
            $products[]=[$o,$orderPro,$discount];
            $orderPro=[];
        }
        return view('admin.orders',['orders'=>$products]);
    }
    public function updateStatus(Request $req){
        $id=$req->id;
        $status=$req->status;
        $update=Order::where('id',$id)->first();
        $update->status=$status;
        if($update->save())
        return redirect()->back();

    }
    public function exportCsv(Request $request)
    {
   $fileName = 'Orders.csv';
   $tasks=DB::table('orders')->join('user_addresses','orders.address_id','=','user_addresses.id')
   ->select('orders.id as oid','orders.coupon_used as used','orders.amount as amount','user_addresses.*','orders.status as status')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        );

        $columns = array('Id', 'Name', 'email', 'address','state','city','pincode','mobile','address_type','amount','status');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $row['Id']  = $task->oid;
                $row['Name']    = $task->fullName;
                $row['email']  = $task->email;
                $row['address']    = $task->address;
                $row['state']  = $task->state;
                $row['city']=$task->city;
                $row['pincode']=$task->pincode;
                $row['mobile']=$task->mobile_no;
                $row['address_type']=$task->address_type;
                $row['amount']=$task->amount;
                $row['status']=$task->status;
                

                fputcsv($file, array($row['Id'], $row['Name'], $row['email'],$row['address'],$row['state'],$row['city'],$row['pincode'],$row['mobile'],$row['address_type'],$row['amount'],$row['status'] ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
}
}