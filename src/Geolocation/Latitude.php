<?php

namespace Fortunato\Geomail\Geolocation;

use Webmozart\Assert\Assert;

final class Latitude
{
    /**
     * @var string
     */
    private $latitude;

    /**
     * @param string $latitude
     */
    private function __construct($latitude)
    {
        Assert::string($latitude);

        $latitude = (float) $latitude;
        Assert::greaterThanEq($latitude, -90);
        Assert::lessThanEq($latitude, 90);

        $this->latitude = (string) $latitude;
    }

    /**
     * @param string $latitude
     * @return Latitude
     */
    public static function fromString($latitude)
    {
        return new Latitude($latitude);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->latitude;
    }
}
