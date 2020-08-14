<?php

namespace NotificationChannels\Nigeriabulksms;

use Exception;
use NotificationChannels\Nigeriabulksms\Exceptions\CouldNotSendNotification;
use NotificationChannels\Nigeriabulksms\Exceptions\InvalidPhonenumber;

class NigeriabulksmsClient
{
    /** @var array */
    protected $config;

    public function __construct($config)
    {
       $this->config = $config;
    }

    /**
     * Send the Message.
     * @param NigeriabulksmsMessage $message
     * @return
     * @throws CouldNotSendNotification
     */
    public function send(NigeriabulksmsMessage $message)
    {
        if (empty($message->from)) {
            $message->setFrom($this->config["sender"]);
        }

        if (empty($message->recipients)) {
            throw InvalidPhonenumber::configurationNotSet();
            // $message->setRecipients($this->config["recipients"]);
        }
   
        try {

            $username = 'username'; //$this->config["username"]);

            $password = 'password'; //$this->config["password"]);
            
            $sender   = 'sender'; //$message->getFrom();
            
            $smsMessage  = 'This is a test message.'; //$message->getContent();
            
            $recipients = $message->getrecipients();

            $api_url  = 'http://portal.nigeriabulksms.com/api/';
            
            //Create the message data
            $data = array('username'=>$username, 'password'=>$password, 'sender'=>$sender, 'message'=>$smsMessage, 'mobiles'=>$recipients);
            
            //URL encode the message data
            $data = http_build_query($data);
            
            //Send the message
            $ch = curl_init(); // Initialize a cURL connection
            
            curl_setopt($ch,CURLOPT_URL, $api_url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
            
            $result = curl_exec($ch);
            
            $result = json_decode($result);

            return $result;

        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
