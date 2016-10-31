<?php

namespace Geomail\Parser;

use Geomail\Geolocation\Location;

class JsonLocationsParser implements LocationsParser
{
    /**
     * @param mixed $input
     * @param string $latField
     * @param string $lonField
     * @param string $emailField
     * @return Location[]
     */
    public function __invoke($input, $latField, $lonField, $emailField)
    {
        $json = json_decode(file_get_contents($input), true);

        $parser = new ArrayLocationsParser;

        return $parser($json, $latField, $lonField, $emailField);
    }
}
