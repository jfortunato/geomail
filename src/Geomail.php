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
     * @var Config
     */
    private $config;

    /**
     * @param Message $message
     * @param Mailer $mailer
     * @param Locator $locator
     * @param Config $config
     */
    public function __construct(Message $message, Mailer $mailer, Locator $locator, Config $config)
    {
        $this->message = $message;
        $this->mailer = $mailer;
        $this->locator = $locator;
        $this->config = $config;
    }

    /**
     * Factory method for creating a new Geomail instance using
     * some default collaborators.
     *
     * @param $subject
     * @param $html
     * @param array $config
     * @param bool $isDevMode
     * @return Geomail
     */
    public static function prepare($subject, $html, array $config, $isDevMode = false)
    {
        $message = new Message($subject, $html);

        return GeomailFactory::prepareDefault($message, Config::fromArray($config, $isDevMode));
    }

    /**
     * Sends an email message to the closest location to the postal code.
     *
     * @param PostalCode $postalCode
     * @param array $locations
     * @throws Exception\LocationOutOfRangeException
     */
    public function sendClosest(PostalCode $postalCode, array $locations)
    {
        Assert::notEmpty($locations);

        $locations = $this->convertToLocations($locations);

        $location = $this->locator->closestToPostalCode($postalCode, $locations, $this->config->getRange());

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
