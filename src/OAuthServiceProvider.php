<?php namespace SSX\OAuth;

use \Illuminate\Support\ServiceProvider;
use \OAuth\ServiceFactory;
use \OAuth\Common\Storage\Eloquent;

class OAuthServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Fix for PSR-4
        $this->package('ssx/oauth', 'oauth', realpath(__DIR__));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('oauth', function($app)
        {
            $factory = new ServiceFactory;

            $session = $app->make('session')->driver();
            $storage = new \OAuth\Common\Storage\Eloquent($session);

            return new OAuth($factory, $storage);
        });
    }
}
