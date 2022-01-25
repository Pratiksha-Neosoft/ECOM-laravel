@section('page_title','Update Cms')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>Update Cms</h2>
        <a href="{{url('admin/view-cms')}}" class="btn btn-success">Back</a>
    </div>
    <div class="card ">
        <div class="card-body">
            <form enctype="multipart/form-data" method="post" action="{{ url('admin/edit-cms/'.$CmsDetails->id) }}" >
              @csrf 
                <div class="control-group">
                  <label>Cms Image</label>
                    <input name="image" id="image" type="file" class="form-control-file"><span class="filename">
                    @if(!empty($CmsDetails->image))
                      <img src="{{asset('/images/frontend_images/Cms').'/'.$CmsDetails->image}}" width="50" height="50" class="m-2" alt="Previous image">
                      <input type="hidden" name="current_image" value="{{ $CmsDetails->image }}"> 
                    @endif
                </div>
                <div class="control-group">
                  <label class="control-label">Title</label>
                    <input type="text" name="title" id="title" value="{{ $CmsDetails->title }}" class="form-control">
                </div>
                <div class="control-group">
                  <label class="control-label">Description</label>
                    <textarea name="body" id="body" class="form-control">{{ $CmsDetails->body }}</textarea>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Update Cms" class="btn btn-success">
                </div>
            </form>  
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
    <script>
    CKEDITOR.replace( 'body' );
    </script>
@endsection