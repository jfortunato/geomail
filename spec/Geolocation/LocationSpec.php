<?php

namespace spec\Fortunato\Geomail\Geolocation;

use Fortunato\Geomail\Email;
use Fortunato\Geomail\Geolocation\Coordinates;
use Fortunato\Geomail\Geolocation\Latitude;
use Fortunato\Geomail\Geolocation\Location;
use Fortunato\Geomail\Geolocation\Longitude;
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
