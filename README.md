Please Note:
This package is currently very, very alpha while I work a few kinks out.

About
=====

The base of this package came from [jenssegers/laravel-oauth](https://github.com/jenssegers/laravel-oauth) which built on a previous package to provide Laravel session support.

This package will look to mirror Jen's package as closely as possbile while using Eloquent as the storage engine.


Quickstart
==========

Add the package to your `composer.json` and run `composer update`.

    {
        "require": {
            "ssx/oauth": "*"
        }
    }


Add the service provider in `app/config/app.php`:

    'SSX\OAuth\OAuthServiceProvider',


Add the OAuth alias to `app/config/app.php`:

    'OAuth'            => 'SSX\OAuth\Facades\OAuth',


Run the migration to create the table required for storage

    php artisan migrate --package=ssx/oauth


Configure your application tokens using one of the methods below and you should be able to use.









================================================================================
# Old README.md Below

Laravel OAuth
=============

[![Build Status](http://img.shields.io/travis/ssx/laravel-oauth.svg)](https://travis-ci.org/ssx/laravel-oauth) [![Coverage Status](http://img.shields.io/coveralls/ssx/laravel-oauth.svg)](https://coveralls.io/r/ssx/laravel-oauth)

A Laravel 4 OAuth 1 and 2 library, using [PHPoAuthLib](https://github.com/Lusitanian/PHPoAuthLib). This library will use Eloquent models to store tokens and supports the services configuration file that was introduced in Laravel 4.2.

Supported services
------------------

- OAuth1
    - BitBucket
    - Etsy
    - FitBit
    - Flickr
    - Scoop.it!
    - Tumblr
    - Twitter
    - Xing
    - Yahoo
- OAuth2
    - Amazon
    - BitLy
    - Box
    - Dailymotion
    - Dropbox
    - Facebook
    - Foursquare
    - GitHub
    - Google
    - Harvest
    - Heroku
    - Instagram
    - LinkedIn
    - Mailchimp
    - Microsoft
    - PayPal
    - Pocket
    - Reddit
    - RunKeeper
    - SoundCloud
    - Vkontakte
    - Yammer

Installation
------------

Add the package to your `composer.json` and run `composer update`.

    {
        "require": {
            "ssx/oauth": "*"
        }
    }

Add the service provider in `app/config/app.php`:

    'SSX\OAuth\OAuthServiceProvider',

Add the OAuth alias to `app/config/app.php`:

    'OAuth'            => 'SSX\OAuth\Facades\OAuth',

Configuration
-------------

### Option 1: Services configuration file

This package supports configuration through the services configuration file located in `app/config/services.php`:

    'facebook' => array(
        'client_id'     => '',
        'client_secret' => '',
        'scope'         => array(),
    )

### Option 2: The package configuration file

Publish the included configuration file:

    php artisan config:publish jenssegers/oauth

Add your consumer credentials to the configuration file:

    'consumers' => array(

        'facebook' => array(
            'client_id'     => '',
            'client_secret' => '',
            'scope'         => array(),
        )

    )

**Optional:** You can also create a `config/oauth.php` file for your consumer configuration. When the library is loaded for the first time, it will check if that file is present or not.

Usage
-----

Once you have added your credentials, you can create PHPoAuthLib service objects like this:

    $oauth = OAuth::consumer('facebook');

To override the default redirect url, or scope use:

    $oauth = OAuth::consumer('facebook', URL::to('url'), array('email', 'publish_actions'));

Once you have the service object, you can use it to interact with the service's API. 

For more information check out [PHPoAuthLib](https://github.com/Lusitanian/PHPoAuthLib).
