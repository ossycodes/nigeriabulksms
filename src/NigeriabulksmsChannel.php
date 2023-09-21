<?php

namespace NotificationChannels\Nigeriabulksms;

use Illuminate\Notifications\Notification;
use Ossycodes\Nigeriabulksms\Objects\TextMessage;
use Ossycodes\Nigeriabulksms\Client as NigeriabulksmsSDK;
use Ossycodes\Nigeriabulksms\Exceptions\BalanceException;
use Ossycodes\Nigeriabulksms\Exceptions\AuthenticateException;
use Ossycodes\Nigeriabulksms\Exceptions\RequestDeniedException;
use NotificationChannels\Nigeriabulksms\Exceptions\InvalidPhonenumber;
use NotificationChannels\Nigeriabulksms\Exceptions\CouldNotSendNotification;

class NigeriabulksmsChannel
{
    /** @var NigeriabulksmsSDK */
    protected $client;

    public function __construct(NigeriabulksmsSDK $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return object with response body data if succesful
     * @throws \NotificationChannels\Nigeriabulksms\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toNigeriabulksms($notifiable);

        if ($to = $notifiable->routeNotificationFor('nigeriabulksms')) {
            $message->setRecipients($to);
        }

        if (empty($message->from)) {
            $message->setFrom(config('services.nigeriabulksms.sender'));
        }

        if (empty($message->recipients)) {
            throw InvalidPhonenumber::configurationNotSet();
        }

        try {

            $nigeriaBulksmsMessage = new TextMessage();
            $nigeriaBulksmsMessage->sender = $message->getFrom();
            $nigeriaBulksmsMessage->recipients = $message->getRecipients();
            $nigeriaBulksmsMessage->body = $message->getContent();

            return $this->client->message->send($nigeriaBulksmsMessage);

        } catch (AuthenticateException $e) {
            // That means that your username and/or password is incorrect
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        } catch (BalanceException $e) {
            // That means that your balance is insufficient
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        } catch (RequestDeniedException $e) {
            // That means that you do not have permission to perform this action
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        } catch (\Exception $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        }
    }
}
