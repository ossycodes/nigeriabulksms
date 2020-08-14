# Nigeriabulksms notification channel for Laravel

This package makes it easy to send notifications using [Nigeriabulksms]('http://portal.nigeriabulksms.com/) with Laravel 5.5+, 6.x and 7.x



## Contents

- [About](#about)
- [Installation](#installation)
- [Setting up the Nigeriabulksms service](#setting-up-the-nigeriabulksms-service)
- [Usage](#usage)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## About

This package makes it possible to send out Laravel notifications as a `SMS ` using Nigeriabulksms API.

## Installation

You can install this package via composer:

``` bash
composer require ossycodes/nigeriabulksms
```

The service provider gets loaded automatically.

### Setting up the Nigeriabulksms service

You will need to [Register](https://nigeriabulksms.com) to get your `username and password`. Place them inside your `.env` file. Remember to add your Sender ID that you will be using to send the messages. 

```bash
NIGERIABULKSMS_USERNAME=""
NIGERIABULKSMS_PASSWORD=""
NIGERIABULKSMS_SENDER=""
```

To load them, add this to your `config/services.php` . This will load the Nigeriabulksms  data from the `.env` file.file:

```php
'nigeriabulksms' => [
    'username'      => env('NIGERIABULKSMS_USERNAME'),
    'password'           => env('NIGERIABULKSMS_PASSWORD'),
    'sender'          => env('NIGERIABULKSMS_SENDER'),
]
```

Add the `routeNotifcationForNigeriabulksms` method on your notifiable Model.

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Route notifications for the Nigeriabulksms channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForNigeriabulksms($notification)
    {
        return $this->phone;
    }
}
```


## Usage


To use this package, you need to create a notification class, like `NewsWasPublished` from the example below, in your Laravel application. Make sure to check out [Laravel's documentation](https://laravel.com/docs/master/notifications) for this process.


```php
<?php

use NotificationChannels\Nigeriabulksms\NigeriabulksmsChannel;
use NotificationChannels\Nigeriabulksms\NigeriabulksmsMessage;

class NewsWasPublished extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [NigeriabulksmsChannel::class];
    }

    public function toNigeriabulksms($notifiable)
    {
		return (new NigeriabulksmsMessage())
                    ->setContent('Your SMS message content');

    }
}
```

Additionally you can add recipients(the phonenumber the messages will be sent to) (single value or array)

``` php
return (new NigeriabulksmsMessage("Your {$notifiable->service} was ordered!"))->setRecipients($recipients);
```

also you can add who the notification(sms) is sent from, this will overide the 
NIGERIABULKSMS_SENDER="" in your .env

``` php
return (new NigeriabulksmsMessage("Your {$notifiable->service} was ordered!"))->setFrom("name of your app");
```

Incase of errors from Nigeriabulksms service please do well to check [Nigeriabulksms api error codes on thier developer portal](https://nigeriabulksms.com/sms-gateway-api/)

## Security

If you discover any security-related issues, please email osaigbovoemmanuel1@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Osaigbovo Emmanuel](https://github.com/ossycodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## How do I say Thank you?

Leave a star and follow me on [Twitter](https://twitter.com/ossycodes) .
