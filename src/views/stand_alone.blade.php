<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('shopify/css/shopify-app-framework.css') }}">
</head>
<body>

@yield('content')

</body>
</html>