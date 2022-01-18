@section('page_title','Add Coupon')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>ADD COUPON</h2>
        <a href="{{url('admin/view-coupons')}}" class="btn btn-success">Back</a>
    </div>
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
    @endif
    <div class="card ">
        <div class="card-body">
            <form method="post" action="{{ url('admin/add-coupon') }}" name="add_coupon" id="add_coupon">{{ csrf_field() }}
                <div class="form-group">
                  <label class="control-label">Amount Type</label>
                    <select name="amount_type" id="amount_type" style="width:220px;" class="form-control">
                      <option value="Percentage">Percentage</option>
                      <option value="Fixed">Fixed</option>
                    </select>
                    @error('amount_type')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                  <label class="control-label">Coupon Code</label>
                    <input type="text" name="coupon_code" id="coupon_code"  class="form-control" value="{{old('coupon_code')}}">
                    @error('coupon_code')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                  <label class="control-label">Amount</label>
                    <input type="number" name="amount" id="amount"  class="form-control" value="{{old('amount')}}">
                    @error('amount')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                  <label class="control-label">Minimum Order Amount</label>
                    <input type="number" name="minimum_amount" id="minimum_amount"  class="form-control" value="{{old('minimum_amount')}}">
                    @error('minimum_amount')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                  <label class="control-label">Enable</label>
                    <input type="checkbox" name="status" id="status" value="1">
                </div>
                <div class="form-actions">
                  <input type="submit" value="Add Coupon" class="btn btn-success">
                </div>
              </form>  
        </div>
    </div>
@endsection