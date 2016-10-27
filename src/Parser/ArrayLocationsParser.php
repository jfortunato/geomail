<?php

namespace Geomail\Parser;

use Geomail\Geolocation\Location;

class ArrayLocationsParser implements LocationsParser
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
        return array_map(function (array $location) use ($latField, $lonField, $emailField) {
            return Location::fromArray([
                'latitude' => $location[$latField],
                'longitude' => $location[$lonField],
                'email' => $location[$emailField],
            ]);
        }, $input);
    }
}
