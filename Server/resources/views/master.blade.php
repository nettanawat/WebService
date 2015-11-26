<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="{!! asset('css/bootstrap-3.3.5-dist/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css">
    <!--    <link href="{!! asset('css/app.css') !!}" rel="stylesheet" type="text/css">-->
    <script type="text/javascript" src="{!! asset('js/jquery.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('css/bootstrap-3.3.5-dist/js/bootstrap.min.js') !!}"></script>
</head>
<body>
@include('menu')

<div style="margin-top: 60px;">
</div>

@yield('content')

<div class="container-fluid navbar-fixed-bottom">
    <p class="text-center">Copyright &copy; nettanawat 2015 All rights reserved</p>
</div>

</body>
</html>