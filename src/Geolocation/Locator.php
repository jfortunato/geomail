<?php

namespace Geomail\Geolocation;

use Geomail\Zip;

interface Locator
{
    /**
     * @param Zip $zip
     * @param array $locations
     * @param $rangeInMiles
     * @return Location
     * @throws LocationOutOfRangeException
     */
    public function closestToZip(Zip $zip, array $locations, $rangeInMiles);
}
