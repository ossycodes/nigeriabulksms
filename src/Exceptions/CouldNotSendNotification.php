<?php

namespace NotificationChannels\Nigeriabulksms\Exceptions;

class CouldNotSendNotification extends \Exception
{
      /**
     * @param string $error
     * @return CouldNotSendNotification
     */
    public static function serviceRespondedWithAnError(string $error): self
    {
        return new static("Nigeriabulksms service responded with an error: {$error}");
    }
}
