@section('page_title','Add product')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>ADD PRODUCTS</h2>
        <a href="{{url('admin/view-products')}}" class="btn btn-success">Back</a>
    </div>
    @if(session()->has('flash_message_err'))
    <div class="text-danger">
        {{session('message')}}
    </div>
    @endif
    <div class="card ">
        <div class="card-body">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/add-product') }}" name="add_product" id="add_product" novalidate="novalidate">
              @csrf
                <div class="form-group">
                  <label class="control-label">Under Category</label>
                  <div class="controls">
                    <select name="category_id" id="category_id" style="width:220px;" class="form-control">
                      <?php echo $categories_drop_down; ?>
                    </select>
                    @error('category_id')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Product Name</label>
                  <div class="controls">
                    <input class='form-control' type="text" name="product_name" id="product_name" value="{{old('product_name')}}">
                    @error('product_name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Product Color</label>
                  <div class="controls">
                    <input class='form-control' type="text" name="product_color" id="product_color" value="{{old('product_color')}}">
                    @error('product_color')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Description</label>
                  <div class="controls">
                    <textarea name="description" class="form-control">{{old('description')}}</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Price</label>
                  <div class="controls">
                    <input class='form-control' type="number" name="price" id="price" value="{{old('price')}}">
                    @error('price')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Image</label>
                  <div class="controls">
                    <input class='form-control-file' name="image" id="image" type="file" value="{{old('image')}}">
                    @error('image')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Feature Item</label>
                  <div class="controls">
                    <input type="checkbox" name="feature_item" id="feature_item" value="1">
                  </div>
                </div>
                <div class="form-actions">
                  <input  type="submit" value="Add Product" class="btn btn-success">
                </div>
              </form>  
        </div>
    </div>
@endsection