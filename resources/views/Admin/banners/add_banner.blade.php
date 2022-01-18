@section('page_title','Add Banner')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>ADD Banner</h2>
        <a href="{{url('admin/view-banners')}}" class="btn btn-success">Back</a>
    </div>
    <div class="card ">
        <div class="card-body">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/add-banner') }}" name="add_banner" id="add_banner" novalidate="novalidate">
                @csrf
                <div class="form-group">
                  <label class="form-control-label">Banner Image</label>
                    <input name="image" id="image" type="file" class="form-control-file">
                    @error('image')
                    <div class="text-danger">
                      {{$message}}
                    </div>
                    @enderror
                  </div>
                <div class="form-group">
                  <label class="control-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}">
                    @error('title')
                    <div class="text-danger">
                      {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="control-group">
                  <label class="control-label">Description</label>
                  <div class="controls">
                    <textarea type="text" name="description" id="description" class="form-control" >{{old('description')}}</textarea>
                    @error('description')
                    <div class="text-danger">
                      {{$message}}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Enable</label>
                  <div class="controls">
                    <input type="checkbox" name="status" id="status" value="1">
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Add Banner" class="btn btn-success">
                </div>
              </form>  
        </div>
    </div>
@endsection