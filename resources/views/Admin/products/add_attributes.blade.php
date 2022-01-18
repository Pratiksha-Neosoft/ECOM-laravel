@section('page_title','Add Coupon')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>ADD ATTRIBUTE</h2>
        <a href="{{url('admin/view-products')}}" class="btn btn-success">Back</a>
    </div>
    @if(session()->has('flash_message_success'))
    <div class="alert text-success">
        {{session('flash_message_success')}}
    </div>
    @endif
    <div class="card ">
        <div class="card-body">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/add-attributes/'.$productDetails->id) }}" name="add_product" id="add_product" novalidate="novalidate">{{ csrf_field() }}
                <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                <div class="form-group">
                  <label >Category Name:</label>
                  {{ $category_name }}
                </div>
                <div class="form-group">
                  <label >Product Name:</label>
                  {{ $productDetails->product_name }}
                </div>
                <div class="form-group">
                  <label >Product Color:</label>
                  {{ $productDetails->product_color }}
                </div>
                <div class="form-group">
                    <input required class="form-control" title="Required" type="text" name="attr_name"  placeholder="Attribute Name" >
                </div>
                @error('attr_name')
                <div class="text-danger">
                {{$message}}
                </div>
                @enderror
                <div class="form-group">
                    <input required title="Required" class="form-control" type="text" name="attr_val" id="size" placeholder="Attribute Value" >                    
                  </div>
                  @error('attr_val')
                  <div class="text-danger">
                  {{$message}}
                  </div>
                  @enderror
               
                <div class="form-actions">
                  <input type="submit" value="Add Attributes" class="btn btn-success">
                </div>
              </form>
        </div>
    </div>
    <form method="post" action="{{ url('admin/edit-attributes/'.$productDetails->id) }}">
      @csrf
        <table class="table table-bordered data-table">
          <thead>
            <tr>
              <th>Attribute ID</th>
              <th>Name</th>
              <th>Value</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $cnt=1;?>  
            @foreach($productDetails->attributes as $attribute)
            <tr>
              <td><input type="hidden" name="id" value="{{$attribute->id}}">{{$cnt}}</td>
              <td class="center"><input type="text" value="{{$attribute->name}}" class="form-control" name="name"></td>
              <td class="center"><input type="text" value="{{$attribute->value}}" class="form-control" name="value"></td>
              <td class="center">
                <input type="submit" class="btn btn-primary" value="Update">
                <a href="{{ url('admin/delete-attribute/'.$attribute->id) }}" class="btn btn-danger btn-mini">Delete</a>
              </td>

            </tr>
            <?php $cnt++?>
            @endforeach
          </tbody>
        </table>
      </form>

@endsection