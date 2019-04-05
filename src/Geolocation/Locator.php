<?php

namespace Geomail\Geolocation;

use Geomail\Exception\LocationOutOfRangeException;
use Geomail\PostalCode;

interface Locator
{
    /**
     * @param PostalCode $postalCode
     * @param array $locations
     * @param $rangeInMiles
     * @return Location
     * @throws LocationOutOfRangeException
     */
    public function closestToPostalCode(PostalCode $postalCode, array $locations, $rangeInMiles): Location;
}
