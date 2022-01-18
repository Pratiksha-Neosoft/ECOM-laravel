<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CouponController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function addCoupon(Request $request){
		if($request->isMethod('post')){
            $validated=$request->validate([
                'coupon_code'=>'required|min:5|max:15|unique:coupons,coupon_code',
                'amount_type'=>'required',
                'amount'=>['required','gt:0',Rule::when(($request->amount_type)=='Percentage',['lt:100'])],
                'minimum_amount'=>'required|gt:amount',
            ]);
			$data = $request->all();
            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }
			$coupon = new Coupon;
			$coupon->coupon_code = $data['coupon_code'];	
			$coupon->amount_type = $data['amount_type'];	
			$coupon->amount = $data['amount'];
			$coupon->min_order_amt = $data['minimum_amount'];
			$coupon->status = $status;
			$coupon->save();	
			return redirect()->action([CouponController::class,'viewCoupons'])->with('flash_message_success', 'Coupon has been added successfully');
		}
		return view('admin.coupons.add_coupon');
	}  

	public function editCoupon(Request $request,$id=null){
		if($request->isMethod('post')){
            $validated=$request->validate([
                'coupon_code'=>'required|min:5|max:15',
                'amount_type'=>'required',
                'amount'=>['required','gt:0',Rule::when(($request->amount_type)=='Percentage',['lt:100'])],
                'minimum_amount'=>'required',
            ]);
			$data = $request->all();
			$coupon = Coupon::find($id);
			if(!$coupon->coupon_code==$data['coupon_code']){
				$validated=$request->validate([
					'coupon_code'=>'unique:coupons,coupon_code'
				]);
			$coupon->coupon_code = $data['coupon_code'];
			}
			$coupon->amount_type = $data['amount_type'];	
			$coupon->amount = $data['amount'];
			$coupon->min_order_amt = $data['minimum_amount'];
			if(empty($data['status'])){
				$data['status'] = 0;
			}
			$coupon->status = $data['status'];
			$coupon->save();
			return redirect()->action([CouponController::class,'viewCoupons'])->with('flash_message_success', 'Coupon has been updated successfully');
		}
		$couponDetails = Coupon::find($id);
		return view('admin.coupons.update_coupon')->with(compact('couponDetails'));
	} 

	public function viewCoupons(){
		$coupons = Coupon::orderBy('id','DESC')->get();
		return view('admin.coupons.view_coupons')->with(compact('coupons'));
	}

	public function deleteCoupon($id = null){
        Coupon::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Coupon has been deleted successfully');
    }
}
