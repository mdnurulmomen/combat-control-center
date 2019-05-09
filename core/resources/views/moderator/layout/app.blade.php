<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('assets/editor/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/editor/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/editor/css/bootadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/editor/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/editor/css/bootstrap-toggle.min.css') }}">

    <title>Dashboard | Online News Admin Panel</title>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="sidebar-toggle mr-3" href="#"><i class="fa fa-bars"></i></a>
    <a class="navbar-brand" href="">Admin Panel</a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{\Illuminate\Support\Facades\Auth::guard('editor')->user()->username}}</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                    <a href="{{ route('editor.update.profile') }}" class="dropdown-item">Profile</a>
                    <a href="{{ route('editor.update.password') }}" class="dropdown-item">Change Password</a>
                    <a href="{{ route('editor.logout') }}" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="d-flex">
    <div class="sidebar sidebar-dark bg-dark">
        <ul class="list-unstyled">
            <li class="active"><a href="{{route('editor.home')}}"><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</a></li>
            <li>
                <a href="#view" data-toggle="collapse">
                    <i class="fa fa-fw fa-cube"></i> Posts
                </a>
                <ul id="view" class="list-unstyled collapse">
                    <li><a href="{{route('editor.view.post')}}">View Posts</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-fw fa-table"></i> Datatables</a></li>
        </ul>
    </div>

    <div class="content p-4">

        @yield('contents')

    </div>
</div>

<script src="{{ asset('assets/editor/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/editor/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/editor/js/bootadmin.min.js') }}"></script>
<script src="{{ asset('assets/editor/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/editor/js/bootstrap-toggle.min.js') }}"></script>
<script src="{{asset('assets/editor/js/nicEdit.js')}}" type="text/javascript"></script>
<script>
    bkLib.onDomLoaded(function () {
        new nicEditor({iconsPath: '../../assets/editor/images/nicEditorIcons.gif'}).panelInstance('textArea');
    });
</script>
<script>
    (function ($) {
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            @if(session()->has('updateMsg'))
            toastr.success("{{ session('updateMsg') }}", "Success")
            @endif
            @if($errors->any())
            @foreach($errors->all() as $error)
            toastr.error("{{ $error }}", "Whoops")
            @endforeach
            @endif
        });
    })(jQuery);
</script>
</body>
</html>