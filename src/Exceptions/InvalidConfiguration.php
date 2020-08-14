<?php

namespace NotificationChannels\Nigeriabulksms\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function configurationNotSet(): self
    {
        return new static("To send notifications via Nigeriabulk SMS you need to add your credentials (username, password and sender) in the `nigeriabulksms` key of `config.services`.");
    }
}
