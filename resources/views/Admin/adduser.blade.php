@section('page_title','Add User')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>ADD USER</h2>
        <a href="{{url('admin/user/view')}}" class="btn btn-success ">Back</a>
    </div>
    <div class="card mt-3">
        <div class="card-body">
        <form action="{{url('admin/user/postadd')}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-form-label">First Name<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="fname" name="fname" value="{{old('fname')}}">
                    @error('fname')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-form-label">Last Name<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="lname" name="lname" value="{{old('lname')}}">
                    @error('lname')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
                    @error('email')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="pass" class="col-sm-2 col-form-label">Password<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="pass" name="password" value="{{old('password')}}">
                    @error('password')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="cpass" class="col-sm-2 col-form-label">Confirm Password<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="cpass" name="password_confirmation" value="{{old('password_confirmation')}}">
                    @error('password_confirmation')
                    <div class="text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
            <fieldset class="form-group">
                <div class="row">
                  <label class="col-form-label col-sm-2 ">Status<span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" id="active" value="active" checked>
                      <label class="form-check-label" for="active">
                        Active
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" id="inactive" value="Inactive">
                      <label class="form-check-label" for="inactive">
                        Inactive
                      </label>
                    </div>
                  </div>
                </div>
              </fieldset>
              <div class="form-group row">
                <label for="role" class="col-sm-2 col-form-label">Role<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <select class="form-control" name="role">
                        @foreach($roles as $role)
                        <option value="{{$role->role_id}}">{{$role->role_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>   
            <input type="submit" class="btn btn-info btn-lg btn-block" value="Submit">
        </form>
        </div>
    </div>
@endsection