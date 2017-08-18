<?php

namespace Geomail\Mailer;

use Geomail\Email;
use Webmozart\Assert\Assert;

final class Message
{
    /**
     * @var Email[]
     */
    private $recipients;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $html;

    /**
     * @param Email[] $recipients
     * @param string $subject
     * @param string $html
     */
    public function __construct(array $recipients, $subject, $html)
    {
        Assert::allIsInstanceOf($recipients, Email::class);
        Assert::greaterThanEq(count($recipients), 1);

        $this->recipients = $recipients;
        $this->subject = $subject;
        $this->html = $html;
    }

    /**
     * @return Email[]
     */
    public function getRecipients()
    {
        return $this->recipients;
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
