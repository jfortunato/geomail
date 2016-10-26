<?php

namespace spec\Geomail\Geolocation;

use Geomail\Email;
use Geomail\Geolocation\Coordinates;
use Geomail\Geolocation\Latitude;
use Geomail\Geolocation\Location;
use Geomail\Geolocation\Longitude;
use PhpSpec\ObjectBehavior;

class LocationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromArray', [[
            'latitude' => '39.766415',
            'longitude' => '-75.112302',
            'email' => 'foo@bar.com',
        ]]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Location::class);
    }

    function it_should_get_the_coordinates()
    {
        $this->getCoordinates()->shouldBeLike(Coordinates::fromLatLon(
            Latitude::fromString('39.766415'),
            Longitude::fromString('-75.112302')
        ));
    }

    function it_should_get_the_email()
    {
        $this->getEmail()->shouldBeLike(Email::fromString('foo@bar.com'));
    }
}
