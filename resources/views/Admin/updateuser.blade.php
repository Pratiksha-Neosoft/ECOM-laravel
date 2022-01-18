@section('page_title','Update User')
@extends('admin.master')
@section('content')
    <div class="p-2">
        <h2>UPDATE USER</h2>
    </div>
    <div class="card card-outline card-primary">
        <div class="card-body">
        <form action="{{url('admin/user/postupdate')}}" method="post">
            @csrf
            <input type="hidden" value={{$user->id}} name="id">
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-form-label">First Name<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="fname" name="fname" value="{{$user->firstname}}">
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
                    <input type="text" class="form-control" id="lname" name="lname" value="{{$user->lastname}}">
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
                    <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}">
                    @error('email')
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
                      <input class="form-check-input" type="radio" name="status" id="active" value="active" {{$user->status=="active"?"checked":""}}>
                      <label class="form-check-label" for="active">
                        Active
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" id="inactive" value="Inactive" {{$user->status=="Inactive"?"checked":""}}>
                      <label class="form-check-label" for="inactive" >
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
                        <option value="{{$role->role_id}}" {{$user->role_id==$role->role_id?"selected":""}}>{{$role->role_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>   
            <div class="float-right">
                <a href="{{url('admin/user/view')}}" class="btn btn-outline-primary">Cancel</a>
                <input type="submit" class="btn btn-success" value="Update User">
            </div>
        </form>
        </div>
    </div>
@endsection