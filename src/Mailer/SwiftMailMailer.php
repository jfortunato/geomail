<?php

namespace Fortunato\Geomail\Mailer;

use Fortunato\Geomail\Config\Config;
use Fortunato\Geomail\Email;
use Swift_Mailer;
use Swift_Message;

final class SwiftMailMailer implements Mailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var Config
     */
    private $config;

    public function __construct(Swift_Mailer $mailer, Config $config)
    {
        $this->mailer = $mailer;
        $this->config = $config;
    }

    /**
     * @param Message $message
     * @param Email $to
     */
    public function sendHtml(Message $message, Email $to)
    {
        $message = Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject($message->getSubject())
            ->setFrom((string) $this->config->getMailerFrom())
            ->setTo((string) $to)
            ->setBody($message->getHtml());

        $this->mailer->send($message);
    }
}

