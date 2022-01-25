@section('page_title','Update Category')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>Update Coupon</h2>
        <a href="{{url('admin/view-coupons')}}" class="btn btn-success">Back</a>
    </div>
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
    @endif
    <div class="card ">
        <div class="card-body">
            <form class="form-horizontal" method="post" action="{{ url('admin/edit-coupon/'.$couponDetails->id) }}" name="add_coupon" id="add_coupon">{{ csrf_field() }}
                <div class="form-group">
                  <label >Amount Type</label>
                    <select name="amount_type" id="amount_type" style="width:220px;" class="form-control">
                      <option @if($couponDetails->amount_type=="Percentage") selected @endif value="Percentage">Percentage</option>
                      <option @if($couponDetails->amount_type=="Fixed") selected @endif value="Fixed">Fixed</option>
                    </select>
                    @error('amount_type')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                  <label >Coupon Code</label>
                    <input value="{{ $couponDetails->coupon_code }}" type="text" name="coupon_code" id="coupon_code" class="form-control">
                    @error('coupon_code')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                  <label >Amount</label>
                    <input value="{{ $couponDetails->amount }}" type="number" name="amount" id="amount" class="form-control">
                    @error('amount')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                  <label >Minimum Order Amount</label>
                    <input value="{{ $couponDetails->min_order_amt }}" type="number" name="minimum_amount" id="minimum_amount" class="form-control">
                    @error('minimum_amount')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                  <label >Enable</label>
                    <input type="checkbox" name="status" id="status" value="1" @if($couponDetails->status=="1") checked @endif>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Update Coupon" class="btn btn-success">
                </div>
              </form>
        </div>
    </div>
@endsection