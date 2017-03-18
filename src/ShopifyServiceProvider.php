<?php

namespace DigitalWheat\Shopify;

use Illuminate\Support\ServiceProvider;
use Route;

class ShopifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/routes.php' => $this->routesPath(),
        ], 'routes');

        $this->publishes([
            __DIR__.'/config/shopify.php' => config_path('shopify.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/shopify'),
        ], 'views');

        $this->publishes([
            __DIR__.'/assets' => public_path('shopify'),
        ], 'views');

        $this->mergeConfigFrom(__DIR__.'/config/shopify.php', 'shopify');
        $this->loadViewsFrom(__DIR__.'/views', 'shopify');
        $this->commands('command.shopify.table');

        if (! $this->app->routesAreCached() && config('shopify.app.use_package_routes')) {
            $this->mapRoutes();
        }
    }

    protected function routesPath()
    {
        return $this->hasRoutesDirectory() ? base_path('routes/shopify.php') : app_path('Http/shopify.php');
    }

    protected function hasRoutesDirectory()
    {
        return is_dir(base_path('routes'));
    }

    protected function mapRoutes()
    {
        if ($this->hasRoutesDirectory() && file_exists(base_path('routes/shopify.php'))) {
            $routes = base_path('routes/shopify.php');
        } elseif (file_exists(app_path('Http/shopify.php'))) {
            $routes = app_path('Http/shopify.php');
        } else {
            $routes = __DIR__.'/routes.php';
        }

        Route::group(['namespace' => 'DigitalWheat\Shopify\Controllers'], function () use ($routes) {
            require $routes;
        });
    }

    public function register()
    {
        $this->app->bind(ApiCallsStore::class, function () {
            return app(config('shopify.app.api.call_limit_store'));
        });

        $this->app->bind(ApiClientFactory::class, function () {
            return app(config('shopify.app.api.client_factory'));
        });

        $this->app->bind(ShopifySignatureHttp::class, function () {
            return new ShopifySignatureHttp(request()->all());
        });

        $this->app->bind(ShopifySignatureWebhook::class, function () {
            return new ShopifySignatureWebhook([
                'header' => request()->header('X-Shopify-Hmac-SHA256'),
                'data' => file_get_contents('php://input'),
            ]);
        });

        $this->app->bind('shopify.user', function () {
            return app(config('auth.providers.users.model'));
        });

        $this->app->singleton('command.shopify.table', function () {
            return new ShopifyTableCommand();
        });

        $this->registerMiddleware();
    }

    protected function registerMiddleware()
    {
        $routeMiddleware = [
            'shopify.paying' => \DigitalWheat\Shopify\Middleware\ChargeAccepted::class,
            'shopify.charged' => \DigitalWheat\Shopify\Middleware\HasChargeId::class,
            'shopify.shopify_domain' => \DigitalWheat\Shopify\Middleware\HasShopifyDomain::class,
            'shopify.login' => \DigitalWheat\Shopify\Middleware\LoginShop::class,
            'shopify.guest' => \DigitalWheat\Shopify\Middleware\RedirectIfLoggedIn::class,
            'shopify.signed' => \DigitalWheat\Shopify\Middleware\SignedByShopify::class,
            'shopify.webhook_signed' => \DigitalWheat\Shopify\Middleware\WebhookSignedByShopify::class,
        ];

        foreach ($routeMiddleware as $key => $middleware) {
            Route::aliasMiddleware($key, $middleware);
        }
    }
}