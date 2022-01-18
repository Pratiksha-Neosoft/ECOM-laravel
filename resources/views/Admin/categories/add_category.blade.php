@section('page_title','Add User')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>ADD CATEGORY</h2>
        <a href="{{url('admin/category')}}" class="btn btn-success">Back</a>
    </div>
    <div class="card ">
        <div class="card-body">
        <form action="{{route('category.insert')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="category_name" class="">Category Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{old('category_name')}}">
                    @error('category_name')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
            </div>
            <div class="form-group ">
                <label for="category_slug" class=" col-form-label">Category Slug<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="category_slug" name="category_slug" value="{{old('category_slug')}}">
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