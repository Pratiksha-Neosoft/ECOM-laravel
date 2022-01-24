@section('page_title','Report')
@extends('admin.master')
@section('content')
<div class="row">
<div class="card col-sm-6">
<div class="card-header">
Registered users report:
</div>
<p class="card-body">
<a href="{{url('downloadUser')}}"  id="export" class="btn btn-primary">Download</a>
</p>
</div>
<div class="card col-sm-6">
<div class="card-header">    
Sales report:
</div>
<p class="card-body">
<a href="{{url('downloadOrder')}}"  id="export" class="btn btn-primary">Download</a>
</p>
</div>
<div class="card col-sm-6">
    <div class="card-header">
    Used Coupon report:
    </div>
    <p class="card-body">
    <a href="{{url('downloadCoupon')}}"  id="export" class="btn btn-primary">Download</a>
    </p>
    </div>    
</div>
@endsection