<?php

namespace Geomail\Mailer;

use Geomail\Config\Config;
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
     */
    public function sendHtml(Message $message)
    {
        /** @var Swift_Message $swiftMessage */
        $swiftMessage = Swift_Message::newInstance()
            ->setContentType('text/html')
            ->setSubject($message->getSubject())
            ->setFrom((string) $this->config->getMailerFrom())
            ->setTo((string) $message->getRecipient())
            ->setBody($message->getHtml());

        // always send to the main email unless it is already the recipient
        if ($message->getRecipient() != $this->config->getAlwaysSendEmail()) {
            $swiftMessage->setBcc((string) $this->config->getAlwaysSendEmail());
        }

        $this->mailer->send($swiftMessage);
    }
}

