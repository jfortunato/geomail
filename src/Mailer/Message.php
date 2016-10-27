<?php

namespace Geomail\Mailer;

use Geomail\Email;

final class Message
{
    /**
     * @var Email
     */
    private $recipient;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $html;

    /**
     * @param Email $recipient
     * @param string $subject
     * @param string $html
     */
    public function __construct(Email $recipient, $subject, $html)
    {
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->html = $html;
    }

    /**
     * @return Email
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }
}
