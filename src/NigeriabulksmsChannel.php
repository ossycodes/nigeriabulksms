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

        try {
            $data = $this->client->send($message);
        } catch (CouldNotSendNotification $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        }

        return $data;
    }
}
