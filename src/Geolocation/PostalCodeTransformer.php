<?php

namespace Geomail\Geolocation;

use Geomail\Exception\UnknownCoordinatesException;
use Geomail\PostalCode;

interface PostalCodeTransformer
{
    /**
     * @param PostalCode $postalCode
     * @return Coordinates
     * @throws UnknownCoordinatesException
     */
    public function toCoordinates(PostalCode $postalCode);
}
