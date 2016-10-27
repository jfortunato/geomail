<?php

namespace Geomail\Parser;

use Geomail\Geolocation\Location;

interface LocationsParser
{
    /**
     * @param mixed $input
     * @param string $latField
     * @param string $lonField
     * @param string $emailField
     * @return Location[]
     */
    public function __invoke($input, $latField, $lonField, $emailField);
}