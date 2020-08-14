<?php

namespace NotificationChannels\Nigeriabulksms;

use Illuminate\Support\ServiceProvider;
use NotificationChannels\Nigeriabulksms\Exceptions\InvalidConfiguration;

class NigeriabulksmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(NigeriabulksmsChannel::class)
            ->needs(NigeriabulksmsClient::class)
            ->give(function () {
                $config = config('services.nigeriabulksms');

                if (is_null($config)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                return new NigeriabulksmsClient($config);
            });
    }
}
