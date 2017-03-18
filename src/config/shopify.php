<?php

return [

    'app' => [

        'use_package_routes' => true,

        /**
         *  https://docs.shopify.com/api/authentication/oauth#get-the-client-redentials
         */
        'client_id' => env('SHOPIFY_KEY'),
        'client_secret' => env('SHOPIFY_SECRET'),

        /**
         *  https://docs.shopify.com/api/authentication/oauth#scopes
         */
        'scope' => implode(',', [
            'read_content',
            'read_themes',
            'read_products',
            'read_customers',
            'read_orders',
            'read_script_tags',
            'read_fulfillments',
            'read_shipping',
        ]),

        /**
         *  https://docs.shopify.com/api/recurringapplicationcharge#create
         */
        'plans' => [

            'test' => [
                'name' => 'Test Plan',
                'price' => 0.99,
                'return_url' => env('APP_URL', 'http://localhost').'/activate',
                'trial_day' => 0,
                'test' => true,
            ],

            'basic' => [
                'name' => 'Basic Plan',
                'price' => 9.00,
                'return_url' => env('APP_URL', 'http://localhost').'/activate',
                'trial_day' => 21,
                'test' => false,
            ],

        ],

        /**
         * Webhooks to create when Shopify store installs app
         * https://help.shopify.com/api/reference/webhook
         */
        'webhooks' => [

            [
                'address' => env('APP_URL', 'http://localhost').'/webhooks/app/uninstalled',
                'topic' => 'app/uninstalled',
            ],

        ],

        /**
         * https://help.shopify.com/api/guides/api-call-limit
         */
        'api' => [

            /**
             * Available options:
             * \DigitalWheat\Shopify\ShopifyApiClientFactory
             * \DigitalWheat\Shopify\CallLimitApiClientFactory
             */
            'client_factory' => \DigitalWheat\Shopify\CallLimitApiClientFactory::class,

            /**
             * Available options:
             * \DigitalWheat\Shopify\ApiCallsArray
             * \DigitalWheat\Shopify\ApiCallsCache
             */
            'call_limit_store' => \DigitalWheat\Shopify\ApiCallsCache::class,

        ],

    ],

];
