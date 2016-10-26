<?php

namespace Geomail\Geolocation;

use Geomail\Zip;

final class HaversineLocator implements Locator
{
    const EARTH_RADIUS = 6371000;

    /**
     * @var ZipTransformer
     */
    private $transformer;

    /**
     * @param ZipTransformer $transformer
     */
    public function __construct(ZipTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param Zip $zip
     * @param array $locations
     * @return Location
     */
    public function closestToZip(Zip $zip, array $locations)
    {
        $center = $this->transformer->toCoordinates($zip);

        $distances = array_map(function (Location $location) use ($center) {
            return ['location' => $location, 'distance' => $this->distance($center, $location->getCoordinates())];
        }, $locations);

        usort($distances, function ($a, $b) {
            return $a['distance'] < $b['distance'] ? -1 : 1;
        });

        return $distances[0]['location'];
    }

    /**
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

        return $angle * self::EARTH_RADIUS;
    }
}
