<?php

namespace NotificationChannels\Nigeriabulksms;

use Illuminate\Notifications\Notification;
use NotificationChannels\Nigeriabulksms\Exceptions\CouldNotSendNotification;

class NigeriabulksmsChannel
{
    /** @var \NotificationChannels\Nigeriabulksms\NigeriabulksmsClient */
    protected $client;

    public function __construct(NigeriabulksmsClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return object with response body data if succesful response from API | empty array if not
     * @throws \NotificationChannels\Nigeriabulksms\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toNigeriabulksms($notifiable);

        if ($to = $notifiable->routeNotificationFor('nigeriabulksms')) {
            $message->setRecipients($to);
        }

        $result = $this->client->send($message);
        
        if (isset($result->status) && strtoupper($result->status) == 'OK') {
            return $result;
        } else if (isset($result->error)) {
            // Message failed, check reason.
            throw CouldNotSendNotification::serviceRespondedWithAnError("Message failed - error: $result->error");
        } else {
            // Could not determine the message response.
            throw CouldNotSendNotification::serviceRespondedWithAnError("Unable to process request");
        }
    }
}
