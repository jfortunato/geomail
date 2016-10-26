<?php

namespace Geomail\Geolocation;

use Geomail\Zip;

interface ZipTransformer
{
    /**
     * @param Zip $zip
     * @return Coordinates
     */
    public function toCoordinates(Zip $zip);
}
