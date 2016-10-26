<?php

namespace Geomail;

use Geomail\Config\Config;
use Geomail\Factory\GeomailFactory;
use Geomail\Geolocation\Location;
use Geomail\Geolocation\Locator;
use Geomail\Mailer\Mailer;
use Geomail\Mailer\Message;
use Webmozart\Assert\Assert;

final class Geomail
{
    /**
     * @var Message
     */
    private $message;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var Locator
     */
    private $locator;

    /**
     * @param Message $message
     * @param Mailer $mailer
     * @param Locator $locator
     */
    public function __construct(Message $message, Mailer $mailer, Locator $locator)
    {
        $this->message = $message;
        $this->mailer = $mailer;
        $this->locator = $locator;
    }

    /**
     * Factory method for creating a new Geomail instance using
     * some default collaborators.
     *
     * @param $subject
     * @param $html
     * @param Config $config
     * @return Geomail
     */
    public static function prepare($subject, $html, Config $config)
    {
        $message = new Message($subject, $html);

        return GeomailFactory::prepareDefault($message, $config);
    }

    /**
     * Sends an email message to the closest location to the zip.
     *
     * @param string $zip
     * @param array $locations
     */
    public function sendClosest($zip, array $locations)
    {
        Assert::notEmpty($locations);

        $locations = $this->convertToLocations($locations);

        $location = $this->locator->closestToZip(Zip::fromString($zip), $locations);

        $this->mailer->sendHtml($this->message, $location->getEmail());
    }

    /**
     * @param array $locations
     * @return array
     */
    private function convertToLocations(array $locations)
    {
        return array_map(function (array $location) {
            Assert::keyExists($location, 'latitude');
            Assert::keyExists($location, 'longitude');
            Assert::keyExists($location, 'email');

            return Location::fromArray($location);
        }, $locations);
    }
}
