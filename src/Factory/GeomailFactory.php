<?php

namespace Geomail\Factory;

use Geomail\Config\Config;
use Geomail\Geolocation\GoogleMapsZipTransformer;
use Geomail\Geolocation\HaversineLocator;
use Geomail\Geomail;
use Geomail\Mailer\Mailer;
use Geomail\Mailer\Message;
use Geomail\Mailer\SwiftMailMailer;
use Geomail\Request\GuzzleClient;
use GuzzleHttp\Client;
use Swift_Mailer;
use Swift_SmtpTransport;

final class GeomailFactory
{
    /**
     * @param Message $message
     * @param Config $config
     * @return Geomail
     */
    public static function prepareDefault(Message $message, Config $config)
    {
        $mailer = self::createMailer($config);
        $client = new GuzzleClient(new Client);
        $locator = new HaversineLocator(new GoogleMapsZipTransformer($config, $client));

        return new Geomail($message, $mailer, $locator, $config);
    }

    /**
     * @param Config $config
     * @return Mailer
     */
    private static function createMailer(Config $config)
    {
        $transport = Swift_SmtpTransport::newInstance($config->getMailerHost(), $config->getMailerPort())
            ->setUsername($config->getMailerUsername())
            ->setPassword($config->getMailerPassword());

        return new SwiftMailMailer(Swift_Mailer::newInstance($transport), $config);
    }
}
