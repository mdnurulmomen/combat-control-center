<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('assets/editor/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/editor/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/editor/css/custom.css') }}">
    <title>Login | Admin</title>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5" style="margin-top:10rem!important;">
                <div class="card-body">
                    <h5 class="card-title text-center">Sign In</h5>
                    <form method="post" action="{{route('editor.login.submit')}}" class="form-signin">
                        @csrf
                        <div class="form-label-group">
                            <input type="text" name="username" class="form-control" placeholder="username" required autofocus>
                            <label for="inputUserName">Username</label>
                        </div>
                        <div class="form-label-group">
                            <input type="password" name="password" class="form-control" placeholder="password" required>
                            <label for="inputPassword">Password</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Remember password</label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/editor/js/jquery.min.js') }}"></script>
<script src="{{asset('assets/editor/js/toastr.min.js') }}"></script>
<script>
    $(document).ready(function () {
        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr.error("{{ $error }}", "Whoops")
        @endforeach
        @endif
    });
</script>
</body>
</html>