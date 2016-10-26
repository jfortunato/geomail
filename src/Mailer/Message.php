<?php

namespace Geomail\Mailer;

final class Message
{
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $html;

    /**
     * @param string $subject
     * @param string $html
     */
    public function __construct($subject, $html)
    {
        $this->subject = $subject;
        $this->html = $html;
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
