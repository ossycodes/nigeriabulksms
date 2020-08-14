<?php

namespace NotificationChannels\Nigeriabulksms;

class NigeriabulksmsMessage
{
    /** @var string */
    public $content;

    /** @var string|null */
    public $from;

    /** @var string|array */
    public $recipients;


    /**
     * Set content for this message.
     *
     * @param string $content
     * @return this
     */
    public function setContent($content)
    {
        $this->content = trim($content);

        return $this;
    }

    /**
     * Get message content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    public function setRecipients($recipients)
    {
        if (is_array($recipients)) {
            $recipients = implode(',', $recipients);
        }

        $this->recipients = $recipients;

        return $this;
    }

    public function getrecipients() {
        return $this->recipients;
    }
}
