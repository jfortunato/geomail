<?php

namespace Fortunato\Geomail\Geolocation;

use Webmozart\Assert\Assert;

final class Longitude
{
    /**
     * @var string
     */
    private $longitude;

    /**
     * @param string $longitude
     */
    private function __construct($longitude)
    {
        Assert::string($longitude);

        $longitude = (float) $longitude;
        Assert::greaterThanEq($longitude, -180);
        Assert::lessThanEq($longitude, 180);

        $this->longitude = (string) $longitude;
    }

    /**
     * @param string $longitude
     * @return Longitude
     */
    public static function fromString($longitude)
    {
        return new Longitude($longitude);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->longitude;
    }
}
