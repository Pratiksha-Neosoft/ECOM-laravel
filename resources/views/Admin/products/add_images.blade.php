@section('page_title','Add Coupon')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>ADD IMAGE</h2>
        <a href="{{url('admin/view-products')}}" class="btn btn-success">Back</a>
    </div>
    @if(session()->has('flash_message_success'))
    <div class="alert text-success">
        {{session('flash_message_success')}}
    </div>
    @endif
    <div class="card ">
        <div class="card-body">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/add-images/'.$productDetails->id) }}" name="add_product" id="add_product" novalidate="novalidate">
                @csrf
                <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                <div class="control-group">
                  <label class="control-label">Category Name:</label>
                  {{ $category_name }}
                </div>
                <div class="control-group">
                  <label class="control-label">Product Name:</label>
                  {{ $productDetails->product_name }}
                </div>
                <div class="control-group">
                  <label class="control-label">Product Alt Image(s):</label>
                  <div class="controls">
                    <input name="image[]" id="image" type="file" multiple="multiple">
                    @error('image')
                    <div class="text-danger">
                      {{$message}}
                    </div>                        
                    @enderror
                  </div>
                </div>
                <br>
                <div class="form-actions">
                  <input type="submit" value="Add Images" class="btn btn-success">
                </div>
              </form>
        </div>
    </div>
    <table class="table table-bordered data-table">
        <thead>
          <tr>
            <th>Image ID</th>
            <th>Product Name</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $cnt=1?>
          @foreach($productImages as $image)
          <tr>
            <td >{{ $cnt }}</td>
            <td>{{ $productDetails->product_name }}</td>
            <td><img width=130px src="{{ asset('images/products/'.$image->image) }}"></td>
            <td><a href="{{ url('/admin/delete-alt-image/').'/'.$image->id }}" class="btn btn-danger" onclick="return deleteConfirm()">Delete</a></td>
          </tr>
          <?php $cnt++?>
          @endforeach
        </tbody>
      </table>
      <script>
      function deleteConfirm(){
        return confirm("Do you really want to delete this record.");
      }
      </script>
@endsection