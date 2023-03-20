<?php

namespace Geomail;

use Geomail\Config\Config;
use Geomail\Exception\LocationOutOfRangeException;
use Geomail\Exception\UnknownCoordinatesException;
use Geomail\Factory\GeomailFactory;
use Geomail\Geolocation\Location;
use Geomail\Geolocation\Locator;
use Geomail\Mailer\Mailer;
use Geomail\Mailer\Message;
use Webmozart\Assert\Assert;

final class Geomail
{
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $html;
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
     * @param string $subject
     * @param string $html
     * @param Mailer $mailer
     * @param Locator $locator
     * @param Config $config
     */
    public function __construct($subject, $html, Mailer $mailer, Locator $locator, Config $config)
    {
        $this->subject = $subject;
        $this->html = $html;
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
     * @return Geomail
     */
    public static function prepare($subject, $html, array $config)
    {
        return GeomailFactory::prepareDefault($subject, $html, Config::fromArray($config));
    }

    /**
     * Sends an email message to the closest location to the zip.
     * You can optionally specify a message the will be sent when there
     * are no locations within the configured range.
     *
     * @param PostalCode $postalCode
     * @param Location[] $locations
     * @param Message|null $outOfRangeMessage
     * @param bool $considerUnknownAsOutOfRange
     * @return bool Whether any email was sent or not.
     * @throws UnknownCoordinatesException
     */
    public function sendClosest(PostalCode $postalCode, array $locations, Message $outOfRangeMessage = null, bool $considerUnknownAsOutOfRange = true)
    {
        Assert::notEmpty($locations);
        Assert::allIsInstanceOf($locations, Location::class);

        try {
            $location = $this->locator->closestToPostalCode($postalCode, $locations, $this->config->getRange());

            $recipient = $location->getEmail();

            $this->mailer->sendHtml(new Message([$recipient], $this->subject, $this->html));

            return true;
        } catch (LocationOutOfRangeException $e) {
        } catch (UnknownCoordinatesException $e) {
            // There was a problem geocoding the postal code. We can either treat it the same as
            // an out of range exception or throw it for the caller to handle.
            if (!$considerUnknownAsOutOfRange) {
                throw $e;
            }
        }

        if (!$outOfRangeMessage) {
            return false;
        }

        $this->mailer->sendHtml(new Message(
            $outOfRangeMessage->getRecipients(),
            $outOfRangeMessage->getSubject(),
            $outOfRangeMessage->getHtml()
        ));

        return true;
    }

    public function getMailer(): Mailer
    {
        return $this->mailer;
    }
}
