<?php

namespace Geomail\Geolocation;

use Geomail\Zip;

interface Locator
{
    /**
     * @param Zip $zip
     * @param array $locations
     * @return Location
     */
    public function closestToZip(Zip $zip, array $locations);
}
