@section('page_title','Update Category')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>Update Category</h2>
        <a href="{{url('admin/category')}}" class="btn btn-success">Back</a>
    </div>
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
    @endif
    <div class="card ">
        <div class="card-body">
        <form action="{{url('admin/category/postupdate/').'/'.$cat->category_slug}}" method="post">
            @csrf
            <div class="form-group">
                <label for="category_name" class="">Category Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{$cat->category_name}}">
                    @error('category_name')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
            </div>
            <div class="form-group ">
                <label for="category_slug" class=" col-form-label">Category Slug<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="category_slug" name="category_slug" value="{{$cat->category_slug}}">
                    @error('category_slug')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
            </div> 
                <input type="submit" class="btn btn-info btn-lg btn-block" value="Submit">
        </form>
        </div>
    </div>
@endsection