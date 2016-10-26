<?php

namespace Fortunato\Geomail\Config;

use Fortunato\Geomail\Email;
use Webmozart\Assert\Assert;

class Config
{
    /**
     * @var string
     */
    private $googleMapsApiKey;
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
     * @param string $googleMapsApiKey
     * @param string $mailerHost
     * @param integer $mailerPort
     * @param string $mailerUsername
     * @param string $mailerPassword
     * @param Email $mailerFrom
     */
    private function __construct(
        $googleMapsApiKey,
        $mailerHost,
        $mailerPort,
        $mailerUsername,
        $mailerPassword,
        Email $mailerFrom
    ) {
        Assert::string($googleMapsApiKey);
        Assert::string($mailerHost);
        Assert::integer($mailerPort);
        Assert::string($mailerUsername);
        Assert::string($mailerPassword);

        $this->googleMapsApiKey = $googleMapsApiKey;
        $this->mailerHost = $mailerHost;
        $this->mailerPort = $mailerPort;
        $this->mailerUsername = $mailerUsername;
        $this->mailerPassword = $mailerPassword;
        $this->mailerFrom = $mailerFrom;
    }

    public static function fromArray(array $params)
    {
        return new Config(
            $params['google_maps_api_key'],
            $params['mailer_host'],
            $params['mailer_port'],
            $params['mailer_username'],
            $params['mailer_password'],
            Email::fromString($params['mailer_from'])
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
}
