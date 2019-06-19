<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
     <link rel="stylesheet" type="text/css" href="{{ URL::to('src/css/main.css') }}">
    @yield('styles')
    <style>
        .main {
            width: 50%;
            margin: 45px auto;

        }
    </style>

</head>
<body>
@include('includes.header')
<div class="main">
    @yield('content')
</div>
</body>
</html>