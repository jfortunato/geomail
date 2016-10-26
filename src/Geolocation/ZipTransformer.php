<?php

namespace Fortunato\Geomail\Geolocation;

use Fortunato\Geomail\Zip;

interface ZipTransformer
{
    /**
     * @param Zip $zip
     * @return Coordinates
     */
    public function toCoordinates(Zip $zip);
}
