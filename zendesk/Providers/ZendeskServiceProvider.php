<?php

namespace Zendesk\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ZendeskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('zendesk', function()
        {
            return new \Zendesk\Resource\Zendesk;
        });

        $this->mergeConfigFrom(
            __DIR__.'/../config.php', 'zendesk-config'
        );
    }
}
