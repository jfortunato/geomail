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
            ->setTo((string) $message->getRecipients()[0])
            ->setBody($message->getHtml());

        foreach ($this->config->getAlwaysSendEmails() as $alwaysSendEmail) {
            // always send to this email unless it is already a recipient
            if (!in_array($alwaysSendEmail, $message->getRecipients())) {
                $swiftMessage->setBcc((string) $alwaysSendEmail);
            }
        }

        $this->mailer->send($swiftMessage);
    }
}

