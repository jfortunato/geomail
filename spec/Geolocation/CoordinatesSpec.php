<?php

namespace spec\Geomail\Geolocation;

use Geomail\Geolocation\Coordinates;
use Geomail\Geolocation\Latitude;
use Geomail\Geolocation\Longitude;
use PhpSpec\ObjectBehavior;

class CoordinatesSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromLatLon', [Latitude::fromString('39.766415'), Longitude::fromString('-75.112302')]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Coordinates::class);
    }

    function it_should_get_the_latitude()
    {
        $this->getLatitude()->shouldBeLike(Latitude::fromString('39.766415'));
    }

    function it_should_get_the_longitude()
    {
        $this->getLongitude()->shouldBeLike(Longitude::fromString('-75.112302'));
    }
}
