<!doctype html>
<html lang="en">
<head>
    <title>{{ config('app.name') }} - @yield('title')</title>
    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <script type="text/javascript">
        ShopifyApp.init({
            apiKey: '{{ Config::get('shopify.app.client_id') }}',
            shopOrigin: 'https://{{ Auth::user()->domain }}',
            debug: {{ app()->environment() !== 'production' ? 'true' : 'false' }}
        });
    </script>
    <script type="text/javascript">
        ShopifyApp.ready(function(){
            ShopifyApp.Bar.initialize({

                title: '@yield('title')',
                buttons: {
                    secondary: [
                        {
                            label: 'App Dashboard',
                            message: 'dashboard',
                            href: "{{ route('shopify.dashboard') }}",
                            target: "app"
                        },
                        {
                            label: 'Help',
                            message: 'help',
                            href: "http://example.com/support",
                            target: "new"
                        },
                    ]
                },
            });
        });
    </script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('shopify/css/shopify-app-framework.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="background-color: #ebeef0">

@yield('content')

@yield('script')
<script type="text/javascript">
    ShopifyApp.ready(function(){
        ShopifyApp.Bar.loadingOff()
    });
</script>
</body>
</html>