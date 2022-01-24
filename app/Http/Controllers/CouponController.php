<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\UsedCoupon;
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
                'amount'=>['required','gt:0',Rule::when(($request->amount_type)=='Percentage',['lte:100'])],
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
                'amount'=>['required','gt:0',Rule::when(($request->amount_type)=='Percentage',['lte:100'])],
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
	public function exportCsv(Request $request)
    {
   $fileName = 'coupon.csv';
   $coupons = UsedCoupon::join('coupons','coupons.id','=','used_coupons.coupon_id')->join('users','users.id','=','used_coupons.user_id')->join('orders','orders.id','=','used_coupons.order_id')->get(['coupons.*','users.email as email','used_coupons.coupon_id as cid','used_coupons.order_id as oid','used_coupons.discounted_price as dis','orders.amount as final']);

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Coupon_Id', 'Coupon_Code', 'User', 'Order_Id', 'Amount','Discount_Price','Final_Price');

        $callback = function() use($coupons, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($coupons as $coupon) {
                $row['Coupon_Id']  = $coupon->cid;
                $row['Coupon_Code']    = $coupon->coupon_code;
                $row['User']    = $coupon->email;
                $row['Order_Id']  = $coupon->oid;
                $row['Amount']  = $coupon->amount_type=="Fixed"?"RS.$coupon->amount":"$coupon->amount.%";
                $row['Discount_Price']=$coupon->dis;
				$row['Final_Price']=$coupon->final;

                fputcsv($file, array($row['Coupon_Id'], $row['Coupon_Code'], $row['User'], $row['Order_Id'], $row['Amount'],$row['Discount_Price'],$row['Final_Price']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
