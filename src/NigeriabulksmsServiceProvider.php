<?php

namespace NotificationChannels\Nigeriabulksms;

use Illuminate\Support\ServiceProvider;
use Ossycodes\Nigeriabulksms\Configuration;
use Ossycodes\Nigeriabulksms\Client as NigeriabulksmsSDK;
use NotificationChannels\Nigeriabulksms\Exceptions\InvalidConfiguration;

class NigeriabulksmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(NigeriabulksmsChannel::class)
            ->needs(NigeriabulksmsSDK::class)
            ->give(function () {
                $userName = config('services.nigeriabulksms.username');
                $password = config('services.nigeriabulksms.password');
                $timeout  = config('services.nigeriabulksms.timeout', 10);
                $connectionTimeout = config('services.nigeriabulksms.connection_timeout', 2);

                if (is_null($userName) || is_null($password)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                $config = Configuration::getDefaultConfiguration()
                    ->setUsername($userName)
                    ->setPassword($password)
                    ->setTimeout($timeout)
                    ->setConnectionTimeout($connectionTimeout);

                return new NigeriabulksmsSDK($config);
            });
    }
}
