<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/font-awesome.min.css') }}">
    <title>OTP - Treasure Wars</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover">
        <div class="float-right">
          {{-- <a href="{{route('admin.logout')}}"  class="text-white m-3">Logout</a> --}}
        </div>
      </div>
    </section>
    <section class="lockscreen-content">
      <div class="lock-box">
        
        <p class="text-center">
          @if($admin->profile_picture)
            <img class="rounded-circle user-image" src="{{ asset($admin->profile_picture) }}">
          @else
            <i class="fa fa-user fa-3x" aria-hidden="true"></i>
          @endif
        </p>

        <p class="text-center text-muted m-0">
          Hello {{ $admin->full_name }},
        </p>
          
        @if(session()->has('codeWarning'))
          <p class="text-center text-danger">    
              {{ session('codeWarning') ?? null}} 
          </p>

        @else
          <p class="text-center text-muted">
            an email has been sent with secret code. Please, check your email.
          </p>
          <p class="text-center text-muted">
            Your token is : {{$admin->token->token}}
          </p> 

        @endif

        <form class="unlock-form" action="{{ route('admin.submit_otp_code') }}" method="POST">
          
          @csrf
          @method('POST')

          <div class="form-group d-none">
            <input class="form-control" type="number" name="id" value="{{$admin->id}}" placeholder="Code" autofocus required="true">
          </div>

          <div class="form-group form-row">
            <label class="control-label col-8">Secret Code</label>
                  
            <label class="control-label col-4 text-right">
              @if (session('errors'))
                @foreach ($errors->all() as $error)
                  <p class="text-center text-danger m-0"><b> {{ $error }} </b></p>
                @endforeach
              @endif
            </label>

            <input class="form-control" type="text" name="secret_code" placeholder="Code" autofocus required="true">
          </div>

          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-unlock fa-lg"></i>Verify</button>
          </div>

        </form>    

        <p class="text-center">
            <a href="{{route('admin.generate_new_otp_code', $admin->id)}}">
              Not Found Code ? Click Here.
            </a>
        </p>

        <p class="text-center m-0">
            <a href="{{route('admin.logout')}}" class="mt-3">Logout</a>
        </p>
            
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('assets/admin/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.bundle.min.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('assets/admin/js/bootstrap.bundle.min.js') }}"></script>
  </body>
</html>