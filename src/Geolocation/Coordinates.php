<?php

namespace Geomail\Geolocation;

final class Coordinates
{
    /**
     * @var Latitude
     */
    private $latitude;
    /**
     * @var Longitude
     */
    private $longitude;

    /**
     * @param Latitude $latitude
     * @param Longitude $longitude
     */
    private function __construct(Latitude $latitude, Longitude $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @param Latitude $latitude
     * @param Longitude $longitude
     * @return Coordinates
     */
    public static function fromLatLon(Latitude $latitude, Longitude $longitude)
    {
        return new Coordinates($latitude, $longitude);
    }

    /**
     * @return Latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return Longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
