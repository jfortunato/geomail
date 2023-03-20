<?php

namespace Geomail\Geolocation;

use Geomail\Exception\LocationOutOfRangeException;
use Geomail\Exception\UnknownCoordinatesException;
use Geomail\PostalCode;

final class HaversineLocator implements Locator
{
    const EARTH_RADIUS = 6371000;
    /**
     * @var PostalCodeTransformer
     */
    private $transformer;

    /**
     * @param PostalCodeTransformer $transformer
     */
    public function __construct(PostalCodeTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param PostalCode $postalCode
     * @param array $locations
     * @param integer $rangeInMiles
     * @return Location
     * @throws LocationOutOfRangeException
     * @throws UnknownCoordinatesException
     */
    public function closestToPostalCode(PostalCode $postalCode, array $locations, $rangeInMiles): Location
    {
        $center = $this->transformer->toCoordinates($postalCode);

        $distances = array_map(function (Location $location) use ($center) {
            return ['location' => $location, 'distance' => $this->distance($center, $location->getCoordinates())];
        }, $locations);

        usort($distances, function ($a, $b) {
            return $a['distance'] < $b['distance'] ? -1 : 1;
        });

        $closest = $distances[0];

        if ((int) $closest['distance'] > $rangeInMiles) {
            throw new LocationOutOfRangeException($rangeInMiles);
        }

        return $closest['location'];
    }

    /**
     * Gets the distance between 2 coordinates in miles.
     *
     * @param Coordinates $from
     * @param Coordinates $to
     * @return float
     */
    private function distance(Coordinates $from, Coordinates $to)
    {
        // convert from degrees to radians
        $latFrom = deg2rad((float) (string) $from->getLatitude());
        $lonFrom = deg2rad((float) (string) $from->getLongitude());
        $latTo = deg2rad((float) (string) $to->getLatitude());
        $lonTo = deg2rad((float) (string) $to->getLongitude());

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $meters = $angle * self::EARTH_RADIUS;

        return $meters * 0.000621371192;
    }
}
