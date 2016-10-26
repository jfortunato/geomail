<?php

namespace Geomail\Geolocation;

use Geomail\Email;

final class Location
{
    /**
     * @var Coordinates
     */
    private $coordinates;
    /**
     * @var Email
     */
    private $email;

    /**
     * @param Coordinates $coordinates
     * @param Email $email
     */
    private function __construct(Coordinates $coordinates, Email $email)
    {
        $this->coordinates = $coordinates;
        $this->email = $email;
    }

    /**
     * @param array $location
     * @return Location
     */
    public static function fromArray(array $location)
    {
        return new Location(
            Coordinates::fromLatLon(
                Latitude::fromString($location['latitude']),
                Longitude::fromString($location['longitude'])
            ),
            Email::fromString($location['email'])
        );
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }
}
