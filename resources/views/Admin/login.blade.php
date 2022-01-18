<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @include('admin.includes.head')
</head>
<body class="bg-light">
    <div class="container">
    <form class="mt-3" action="{{route('admin.auth')}}" method="post">
        @csrf()
        <div class="card w-50 mx-auto">
        <div class="card-body">
        <h2 class="text-center">Admin Login</h2>
        <hr width="60%"/>
        <div class="form-group">
          <label for="InputEmail">Email address</label>
          <input type="email" class="form-control" id="InputEmail"  placeholder="Enter email" name="email" value="{{ old('email') }}">
          @error('email')
          <div class="text-danger">
            {{$message}}
          </div>              
          @enderror
        </div>
        <div class="form-group">
          <label for="InputPassword">Password</label> 
          <input type="password" class="form-control" id="InputPassword" placeholder="Password" name="password">
          @error('password')
          <div class="text-danger">
            {{$message}}
          </div>              
          @enderror
        </div>
        <button type="submit" class="btn btn-success w-100">Sign In</button>
        @if(Session::has('error'))
        <div class="alert alert-danger mt-2 alert-dismissible fade show" role="alert" >
          {{session('error')}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        </div>
        </div>
    </form>
    </div>
    @include('admin.includes.foot')
</body>
</html>