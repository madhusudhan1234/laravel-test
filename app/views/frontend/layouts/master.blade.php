<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WebSite | @yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body>

@include('frontend.layouts.navigation')

<div class="container">

    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            <p>{{ Session::get('message') }}</p>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            <p>{{ Session::get('error') }}</p>
        </div>
    @endif

    @yield('content')

</div>
</body>
</html>