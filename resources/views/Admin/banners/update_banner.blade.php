@section('page_title','Update Banner')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>Update Banner</h2>
        <a href="{{url('admin/view-banners')}}" class="btn btn-success">Back</a>
    </div>
    <div class="card ">
        <div class="card-body">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin/edit-banner/'.$bannerDetails->id) }}" name="edit_banner" id="edit_banner" novalidate="novalidate">{{ csrf_field() }}
                <div class="control-group">
                  <label>Banner Image</label>
                    <input name="image" id="image" type="file" class="form-control-file"><span class="filename">
                    @if(!empty($bannerDetails->image))
                      <img src="{{asset('/images/frontend_images/banners').'/'.$bannerDetails->image}}" width="50" height="50" class="m-2" alt="Previous image">
                      <input type="hidden" name="current_image" value="{{ $bannerDetails->image }}"> 
                    @endif
                </div>
                <div class="control-group">
                  <label class="control-label">Title</label>
                    <input type="text" name="title" id="title" value="{{ $bannerDetails->title }}" class="form-control">
                </div>
                <div class="control-group">
                  <label class="control-label">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ $bannerDetails->description }}</textarea>
                </div>
                <div class="control-group">
                  <label class="control-label">Enable</label>
                    <input type="checkbox" name="status" id="status" value="1" @if($bannerDetails->status=="1") checked @endif >
                </div>
                <div class="form-actions">
                  <input type="submit" value="Update Banner" class="btn btn-success">
                </div>
            </form>  
        </div>
    </div>
@endsection