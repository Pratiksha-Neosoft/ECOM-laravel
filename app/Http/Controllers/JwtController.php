<?php

namespace App\Http\Controllers;
	
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product_attribute_assoc;
use App\Models\Product_image;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Cms;
use Illuminate\Support\Facades\Hash;
use App\Models\Wishlist;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\UsedCoupon;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;
use App\Mail\registerMailToUser;
use App\Mail\registerMailToAdmin;
use App\Mail\orderMailToUser;
use App\Mail\orderMailToAdmin;
use App\Models\Product_attributes_assoc;
use Illuminate\Support\Facades\Mail;
use SebastianBergmann\Environment\Console;

class JwtController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['login','register','contact','banner','category','product','coupon','show','productdetails','cmslist','cmsdetails','wishlist','storeWishlist','destroyWishlist','checkCoupon','newsletter']]);
    }
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'firstname'=>'required|min:2|alpha',
            'lastname'=>'required|min:2|alpha',
            'email'=>'required|unique:users|email',
            'password'=>'required|min:6|max:12',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else {
            $user=User::create([
                'firstname'=>$request->firstname,
                'lastname'=>$request->lastname,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),

            ]);
            Mail::to($request->email)->send(new registerMailToUser($request->all()));
            return response()->json([
                'message'=>1,
                'user'=>$user
            ],201);
        }
    }
    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required|min:6|max:12',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else {
            $user=User::where('email',$request->email)->first();
            if ($user->status =="active") {
                if($token=auth()->guard('api')->attempt($validator->validated())){
                return response()->json(['token' => $token,'error'=>0 ,'message' => 'Login successfully.', 'status' => 1, 'email'=>$request->email,'userid'=>$user->id,'firstname'=>$user->firstname,'lastname'=>$user->lastname],200);
                }
            }
           else {
                 return response()->json(['token' => '','error'=>0, 'message' => 'User is inactive.', 'status' => 0]);
                }
        }
    }
    public function contact(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:2',
            'email'=>'required|unique:contacts,email|email',
            'subject'=>'required',
            'message'=>'required|min:10|max:255',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else {
            $contact=Contact::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'subject'=>$request->subject,
                'message'=>$request->message,
            ]);
            return response()->json([
                'error'=>0,
                'contact'=>$contact
            ]);
        }
    }
    public function banner()
    {   $listbanner=[];
        $banner = Banner::where('status','1')->get();
        foreach($banner as $ban){
            $listbanner[]=[
                'caption'=>$ban->title,
                'body'=>$ban->description,
                'image'=> asset('/images/frontend_images/banners/'.$ban->image)
              ];
          }
 
        return response()->json(['banner' => $listbanner]);
    }
    public function product()
    {
        $list=[];
        $listimage=[];
        $product = Product::where('feature_item','1')->get();
        foreach($product as $prod){
        //   foreach($prod->ProductImage as $image){
        //         $listimage[]=[
        //             'image'=> asset('/images/products/'.$image->image)
        //           ];
        //   }
            $img=asset('/images/products/'.$prod->image);
            $list[]=[
                'name'=>$prod->product_name,
                'pid'=>$prod->id,
                'category'=>$prod->category_id,
                // 'attributes'=>$prod->attributes,
                'images'=>$img,
                'price'=>$prod->price
            ];
            $listimage=[];
        }
    
        return response()->json(['product' => $list]);
    }
    public function category()
    {
        $category = Category::all();
        foreach($category as $cat){
            $listcat[]=[
                'id'=>$cat->id,
                'name'=>$cat->category_name
              ];
          }
 
        return response()->json(['category' => $listcat]);
    }
    public function show($id)
    {   $listimage=[];
        $list = [];
        $product = Product::where('category_id',$id)->get();
        foreach ($product as $prod) {
        //     foreach($prod->ProductImage as $image){
        //         $listimage[]=[
        //             'image'=> asset('uploads/'.$image->images)
        //           ];
        //   }
        $img=asset('/images/products/'.$prod->image);
        $list[]=[
            'name'=>$prod->product_name,
            'pid'=>$prod->id,
            'category'=>$prod->category_id,
            // 'attributes'=>$prod->attributes,
            'images'=>$img,
            'price'=>$prod->price
        ];
            $listimage = [];
        }

        return response()->json(['categorybyid' => $list]);
    }
    public function productdetails($id){
        $listimage=[];
        $list = [];
        $attrs=[];
        $prod=Product::find($id);
        $pi=Product_image::where('product_id',$id)->get();
        if($pi){
         foreach($pi as $image){
             $listimage[]=[
                 'image'=> asset('/images/products/'.$image->image)
               ];
        }
        }else{
            $listimage=[];
        }
        $attribute=Product_attributes_assoc::where('product_id',$id)->get();
        if($attribute){
        foreach($attribute as $attr){
            $attrs[]=[
                'name'=> $attr->name,
                'value'=>$attr->value
              ];
        }
        }else{
            $attrs=[];
        }
        $image=asset('/images/products/'.$prod->image);
         $list[] = [
             'name' => $prod->product_name,
             'pid' => $prod->id,
             'price'=>$prod->price,
             'color'=>$prod->product_color,
             'description'=>$prod->description,
             'attributes'=>$attrs,
             'images'=>$listimage,
             'image'=>$image
         ];
         $listimage = [];

     return response()->json(['products'=>$list]);
 }

    public function coupon()
    {
        $coupon = Coupon::all();
        return response()->json(['coupon' => $coupon]);
    }
   
    public function respondWithToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->guard('api')->factory()->getTTL()*60
        ]);
    }
    public function profile(){
       $profile=auth('api')->user();
        return response()->json(['profile'=>$profile]);
    }
    public function updateProfile(Request $request){
        $validated=$request->validate([
            'first_name'=>'required|min:2',
            'last_name'=>'required|min:2',
        ]);
        $profile=auth()->user();
        $update=User::find($profile->id);
        $update->firstname=$request->first_name;
        $update->lastname=$request->last_name;
        if($update->save())
        return response()->json("updated");

    }
    public function changePassword(Request $request){
        $validator=Validator::make($request->all(),[
            'old_password'=>'required|min:6|max:12',
            'new_password'=>'required|min:6|max:12',
            'confirm_password'=>'required|min:6|max:12|same:new_password',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else {
            $user=$request->user();
            if(Hash::check($request->old_password,$user->password)){
               $user->update([
                   'password'=>Hash::make($request->new_password)
               ]);
               return response()->json([
                'message'=>"password successfully updated",
                'status'=>1
                ],200);
            }
           else{
                return response()->json([
                    'message'=>"old password does not match",
                    'status'=>0
                ]);
           }
        }
        return response()->json([
            'message'=>"password successfully updated",
            'status'=>1
        ]);
    }
    public function cmslist(){
        $data=Cms::all();
        return response()->json(['cms'=>$data]);
    }
    public function cmsdetails($id){
        $data=Cms::find($id);
        $title=$data->title;
        $body=str_replace( '&', '&amp;', $data->body );
        if($data->image)
        $image=asset('/images/frontend_images/Cms/'.$data->image);
        else
        $image='';
        return response()->json(['title'=>$title,'body'=>$body,'image'=>$image]);
    }
    public function refresh(){
        return $this->responseWithToken(auth()->guard('api')->refresh());
    }
    public function wishlist($id)
    {
        $wish=Wishlist::where('user_id',$id)->get();
        return response()->json($wish);

    }
    public function storeWishlist(Request $request)
    {
        $check=Wishlist::where('product_id',$request->product_id)->first();
        if(!$check){
        $data=Wishlist::insert([
            "user_id"=>$request->userid,
            "product_id"=>$request->product_id,
            "product_name"=>$request->product_name,
            "product_price"=>$request->product_price,
            "image_path"=>$request->product_image,
        ]);
        return response()->json(["data"=>$data,"message"=>"sucess"]);
        }
        else{
            return response()->json(["message"=>"error"]);
        }
    }
    public function destroyWishlist($id)
    {
        $wish=Wishlist::find($id)->delete();
    
        return response()->json(["data"=>$wish,"message"=>"delete sucess"]);

    }
    public function checkCoupon(Request $request){
        $result=Coupon::where('coupon_code',$request->code)->first();
        if($result){
            if($result->status==1){
                $status="success";
                return response()->json(['status'=>$status,'coupon'=>$result]);
            }
            else{
                $status="error";
                $msg="Coupon code deactivated!";
            }
        }else{
            $status="error";
            $msg="Please enter valid coupon code";
        }
        return response()->json(['status'=>$status,'msg'=>$msg]);
    }
    public function userAddress(Request $request){
        $validator=Validator::make($request->all(),[
            'user_id'=>'required',
            'address'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else {
            $userAd=UserAddress::create([
                'user_id'=>$request->user_id,
                'fullName'=>$request->name,
                'email'=>$request->email,
                'state'=>$request->state,
                'city'=>$request->city,
                'pincode'=>$request->postal,
                'mobile_no'=>$request->mobile,
                'address_type'=>$request->addtype,
                'address'=>$request->address,
            ]);

            return response()->json([
                'error'=>0,
                'user'=>$userAd,
                'address_id'=>$userAd->id
    
            ]);
    
           
        }
            }

    public function order(Request $request){
            $order=Order::create([
                'user_id'=>$request->user_id,
                'address_id'=>$request->address_id,
                'amount'=>$request->amount,
                'coupon_used'=>$request->coupon_used,
                'payment_mode'=>$request->mode
            ]);
            return response()->json([
                'error'=>0,
                'order'=>$order,
                'order_id'=>$order->id
            ]);
    }

    public function orderProduct(Request $request){
            $orderproduct=OrderProduct::create([
                'order_id'=>$request->order_id,
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'total_price'=>$request->total_price,
            ]);
            $order=Order::where('id',$request->order_id)->first();
            $orderP=OrderProduct::where('order_id',$order->id)->first();
            $user=User::where('id',$order->user_id)->first();
            $userMail=$user->email;
            $pro=Product::where('id',$request->product_id)->first();
            Mail::to($userMail)->send(new orderMailToUser($pro));
            return response()->json([
                'error'=>0,
                'orderproduct'=>$orderproduct,
                'order'=>$pro
            ]);
    }
    public function usedCoupon(Request $request){
        $orderproduct=usedCoupon::create([
            'coupon_id'=>$request->coupon_id,
            'user_id'=>$request->user_id,
            'order_id'=>$request->order_id,
            'discounted_price'=>$request->discounted_price,
        ]);
        return response()->json([
            'error'=>0,
            'orderproduct'=>$orderproduct
        ]);
    }
    public function viewOrder($id){
        $orders=DB::table('orders')->join('user_addresses','orders.address_id','=','user_addresses.id')->
        join('order_products','orders.id','order_products.order_id')->join('products','products.id','=','order_products.product_id')->select('orders.id as oid','orders.amount as amount','user_addresses.*','order_products.product_id','products.*','order_products.id as OPid','order_products.quantity as quantity','orders.status as status')->where('orders.user_id',$id)->get();
        return response()->json(['orders'=>$orders]);
    }
    public function myAdd($id){
        $addr=UserAddress::where(['user_id'=>$id,'status'=>'1'])->get();
        return response()->json(['addr'=>$addr]);
    }
    public function delmyAdd($id){
        $addr=UserAddress::find($id);
        $addr->status='0';
        return response()->json(["del"=>$addr->save()]);
    }

     public function logout(){
        auth()->logout();
        return response()->json(["message"=>"User Logout Successfully"]);
    }
    public function newsletter($email){
        if ( ! Newsletter::isSubscribed($email) ) {
            Newsletter::subscribe($email);
        }
    }
}