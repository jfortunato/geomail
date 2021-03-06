<?php

namespace spec\Geomail\Geolocation;

use Geomail\Exception\LocationOutOfRangeException;
use Geomail\Geolocation\Coordinates;
use Geomail\Geolocation\HaversineLocator;
use Geomail\Geolocation\Latitude;
use Geomail\Geolocation\Location;
use Geomail\Geolocation\Locator;
use Geomail\Geolocation\Longitude;
use Geomail\Geolocation\ZipTransformer;
use Geomail\Zip;
use PhpSpec\ObjectBehavior;

class HaversineLocatorSpec extends ObjectBehavior
{
    function let(ZipTransformer $transformer)
    {
        $this->beConstructedWith($transformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HaversineLocator::class);
    }

    function it_is_a_locator()
    {
        $this->shouldHaveType(Locator::class);
    }

    function it_uses_the_haversine_formula_to_determine_the_closest_location_to_a_zip(ZipTransformer $transformer)
    {
        $transformer->toCoordinates(Zip::fromString('08080'))->willReturn(Coordinates::fromLatLon(
            Latitude::fromString('39.766415'),
            Longitude::fromString('-75.112302')
        ));

        $cherryHill = Location::fromArray([
            'latitude' => '39.881709',
            'longitude' => '-74.955948',
            'email' => 'cherryhill@example.com',
        ]);
        $beverlyHills = Location::fromArray([
            'latitude' => '34.103003',
            'longitude' => '-118.410468',
            'email' => 'beverlyHills@example.com',
        ]);

        $this->closestToZip(Zip::fromString('08080'), [$cherryHill, $beverlyHills], 100000)->shouldReturn($cherryHill);
    }

    function it_should_throw_an_exception_if_there_are_no_locations_within_range(ZipTransformer $transformer)
    {
        $transformer->toCoordinates(Zip::fromString('08080'))->willReturn(Coordinates::fromLatLon(
            Latitude::fromString('39.766415'),
            Longitude::fromString('-75.112302')
        ));

        $beverlyHills = Location::fromArray([
            'latitude' => '34.103003',
            'longitude' => '-118.410468',
            'email' => 'beverlyHills@example.com',
        ]);

        $this->shouldThrow(LocationOutOfRangeException::class)->duringClosestToZip(Zip::fromString('08080'), [$beverlyHills], 1000);
    }
}
