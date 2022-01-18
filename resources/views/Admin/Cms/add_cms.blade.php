@section('page_title','Add Cms')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>ADD Cms</h2>
        <a href="{{url('admin/view-cms')}}" class="btn btn-success">Back</a>
    </div>
    <div class="card ">
        <div class="card-body">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/add-cms') }}" name="add_cms" id="add_cms" novalidate="novalidate">
                @csrf
                <div class="form-group">
                  <label class="form-control-label">Cms Image</label>
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
                  <label class="control-label">Body</label>
                  <div class="controls">
                    <textarea type="text" name="body" id="body" class="form-control" >{{old('body')}}</textarea>
                    @error('body')
                    <div class="text-danger">
                      {{$message}}
                    </div>
                    @enderror
                  </div>
                </div>
                <br>
                <div class="form-actions">
                  <input type="submit" value="Add CMS" class="btn btn-success">
                </div>
              </form>  
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
    <script>
    CKEDITOR.replace( 'body' );
    </script>
@endsection