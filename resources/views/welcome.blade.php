<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>poiEngine</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="/css/form.css" rel="stylesheet">
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        @if (Auth::guest())
            <div class="top-right links">
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
            </div>
        @else
            <div class="top-right links">
                {{ Auth::user()->name }} <span class="caret"></span>
            </div>
        @endif
    @endif

    <div class="content">
        <div class="title m-b-md">
            POI engine
        </div>

        <div class="links">
            <a href="{{ url('/poi/poimanager') }}">
                Poi Manager
            </a>
            <a href="#">User Manager</a>
            <a href="#">Group manager</a>
        </div>
    </div>
</div>
</body>
</html>
