<?php

namespace Fortunato\Geomail\Factory;

use Fortunato\Geomail\Config\Config;
use Fortunato\Geomail\Geolocation\GoogleMapsZipTransformer;
use Fortunato\Geomail\Geolocation\HaversineLocator;
use Fortunato\Geomail\Geomail;
use Fortunato\Geomail\Mailer\Mailer;
use Fortunato\Geomail\Mailer\Message;
use Fortunato\Geomail\Mailer\SwiftMailMailer;
use Fortunato\Geomail\Request\GuzzleClient;
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

        return new Geomail($message, $mailer, $locator);
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
