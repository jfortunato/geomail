<?php

namespace Geomail\Factory;

use Geomail\Config\Config;
use Geomail\Geolocation\GoogleMapsZipTransformer;
use Geomail\Geolocation\HaversineLocator;
use Geomail\Geomail;
use Geomail\Mailer\Mailer;
use Geomail\Mailer\SwiftMailMailer;
use Geomail\Request\GuzzleClient;
use GuzzleHttp\Client;
use Swift_Mailer;
use Swift_SmtpTransport;

final class GeomailFactory
{
    /**
     * @param $subject
     * @param $html
     * @param Config $config
     * @return Geomail
     */
    public static function prepareDefault($subject, $html, Config $config)
    {
        $mailer = self::createMailer($config);
        $client = new GuzzleClient(new Client);
        $locator = new HaversineLocator(new GoogleMapsZipTransformer($config, $client));

        return new Geomail($subject, $html, $mailer, $locator, $config);
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
