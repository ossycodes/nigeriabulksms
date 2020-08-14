<?php

namespace NotificationChannels\Nigeriabulksms\Exceptions;

use Exception;

class InvalidPhonenumber extends Exception
{
    public static function configurationNotSet(): self
    {
        return new static(
            "please provide phonenumber(s) to which sms notification will be sent to, you can do these in two ways: 
            1) by defining a routeNotificationForNigeriabulksms method on your notifiable entity
             or
            2) by chaining setRecipients(phonenumber) method to your toNigeriabulksms method in your event class;
             if all these does;nt still make sense please try reading the package documentation again pele!   
            "
        );
    }
}
