<?php

namespace Geomail\Geolocation;

use Geomail\PostalCode;

interface PostalCodeTransformer
{
    /**
     * @param PostalCode $postalCode
     * @return Coordinates
     */
    public function toCoordinates(PostalCode $postalCode);
}
