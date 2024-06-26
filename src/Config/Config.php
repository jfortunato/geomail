<?php

namespace Geomail\Config;

use Geomail\Email;
use Webmozart\Assert\Assert;

class Config
{
    /**
     * @var string
     */
    private $googleMapsApiKey;
    /**
     * @var int
     */
    private $range;
    /**
     * @var string
     */
    private $mailerHost;
    /**
     * @var int
     */
    private $mailerPort;
    /**
     * @var string
     */
    private $mailerUsername;
    /**
     * @var string
     */
    private $mailerPassword;
    /**
     * @var Email
     */
    private $mailerFrom;
    /**
     * @var Email[]
     */
    private $alwaysSendEmails;

    /**
     * @param string $googleMapsApiKey
     * @param integer $range
     * @param string $mailerHost
     * @param integer $mailerPort
     * @param string $mailerUsername
     * @param string $mailerPassword
     * @param Email $mailerFrom
     * @param Email[] $alwaysSendEmails
     */
    private function __construct(
        $googleMapsApiKey,
        $range,
        $mailerHost,
        $mailerPort,
        $mailerUsername,
        $mailerPassword,
        Email $mailerFrom,
        Email ...$alwaysSendEmails
    ) {
        Assert::string($googleMapsApiKey);
        Assert::integer($range);
        Assert::string($mailerHost);
        Assert::integer($mailerPort);
        Assert::string($mailerUsername);
        Assert::string($mailerPassword);

        $this->googleMapsApiKey = $googleMapsApiKey;
        $this->range = $range;
        $this->mailerHost = $mailerHost;
        $this->mailerPort = $mailerPort;
        $this->mailerUsername = $mailerUsername;
        $this->mailerPassword = $mailerPassword;
        $this->mailerFrom = $mailerFrom;
        $this->alwaysSendEmails = $alwaysSendEmails;
    }

    /**
     * @param array $params
     * @return Config
     */
    public static function fromArray(array $params)
    {
        $alwaysSendEmails = array_map(function ($email) {
            return Email::fromString($email);
        }, $params['geomail_always_send_emails']);

        return new Config(
            $params['google_maps_api_key'],
            $params['range'],
            $params['mailer_host'],
            $params['mailer_port'],
            $params['mailer_username'] ?: '',
            $params['mailer_password'] ?: '',
            Email::fromString($params['mailer_from']),
            ...$alwaysSendEmails
        );
    }

    /**
     * @return string
     */
    public function getGoogleMapsApiKey()
    {
        return $this->googleMapsApiKey;
    }

    /**
     * @return int
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @return string
     */
    public function getMailerHost()
    {
        return $this->mailerHost;
    }

    /**
     * @return int
     */
    public function getMailerPort()
    {
        return $this->mailerPort;
    }

    /**
     * @return string
     */
    public function getMailerUsername()
    {
        return $this->mailerUsername;
    }

    /**
     * @return string
     */
    public function getMailerPassword()
    {
        return $this->mailerPassword;
    }

    /**
     * @return Email
     */
    public function getMailerFrom()
    {
        return $this->mailerFrom;
    }

    /**
     * @return Email[]
     */
    public function getAlwaysSendEmails()
    {
        return $this->alwaysSendEmails;
    }
}
