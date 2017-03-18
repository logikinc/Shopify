# Shopify App Laravel Package
Shopify App package for Laravel framework.

**Features:**
- Shopify Friendly UI
- Billing and plans management
- App scopes and webhooks

## Usage

### Create new Shopify App
Login to your [Shopify partner dashboard](https://app.shopify.com/services/partners) and create new app with the following settings:

1. Enable **Embed app in Shopify web admin** option.

2. App URL (Callback URL)
```https://yourapp.com/embedded/dashboard```

3. Redirection URL
```
https://yourapp.com/register
https://yourapp.com/embedded/login
```

You also can install app manually using the following URL:
```
https://yourapp.com/signup
```

### Package installation
To install the package run the following commands:
```
composer require digitalwheat/shopify
composer update
php artisan vendor:publish
php artisan shopify:table
php artisan migrate
```

Next, update your **User** model at **app/User.php**:
- Add **OwnsShopifyStore** trait;
- Extend fillable and protected fields;

So your **User** model will look as follows:
```
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DigitalWheat\Shopify\OwnsShopifyStore;

class User extends Authenticatable
{
    use Notifiable;
	use OwnsShopifyStore;

    //...
    
    protected $fillable = [
        'name', 'email', 'password',
		'shopify_id', 'domain', 'access_token', 'charge_id', 'installed',
    ];
    
    //...
    
    protected $hidden = [
        'password', 'remember_token', 'access_token'
    ];
	
	//...
}
```

### App configuration
1. Add Shopify Service Provider to **Package Service Providers** section in your app config **config/app.php**:
```
'providers' => [
    //...
    
    /*
     * Package Service Providers...
     */
    \DigitalWheat\Shopify\ShopifyServiceProvider::class
    
    //...
 ]
```

2. Configure environment-specific variables in **.ENV** file:
- Application URL (APP_URL)
- Shopify App API Key (SHOPIFY_KEY)
- Shopify App Secret Key (SHOPIFY_SECRET)
```
APP_URL=https://yourapp.com
SHOPIFY_KEY=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
SHOPIFY_SECRET=yyyyyyyyyyyyyyyyyyyyyyyyyyy
```

3. Configure application scope, plans and webhooks in **config/shopify.php**:

The webhook for uninstalling the application is configured by default.

**IMPORTANT:** Your app should be running under secure connection (HTTPS).
To force secure connection on Laravel just add the following code to **boot()** method in **app/Providers/AppServiceProvider.php**:
```
\URL::forceScheme('https'); // for Laravel 5.4
```

## Changelog
```
v1.0.0 - March 18, 2017
** Initial release **
```

## Credits
This package is based on the following:
- [Carter](https://github.com/nickywoolf/carter) 
- [Shopify API Wrapper for Laravel](https://github.com/joshrps/laravel-shopify-API-wrapper)
- [Seaff](http://seaff.microapps.com/)

## [MIT License](https://opensource.org/licenses/MIT)
(c) 2017 [DigitalWheat](https://digitalwheat.com) - All rights reserved.

P.S.: Looking for Laravel hosting? Try [CloudWays](https://www.cloudways.com/en/?id=87439) - Fully Managed Cloud Hosting.