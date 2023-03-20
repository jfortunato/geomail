<?php

namespace spec\Geomail\Geolocation;

use Geomail\Exception\LocationOutOfRangeException;
use Geomail\Exception\UnknownCoordinatesException;
use Geomail\Geolocation\Coordinates;
use Geomail\Geolocation\HaversineLocator;
use Geomail\Geolocation\Latitude;
use Geomail\Geolocation\Location;
use Geomail\Geolocation\Locator;
use Geomail\Geolocation\Longitude;
use Geomail\Geolocation\PostalCodeTransformer;
use Geomail\PostalCode;
use PhpSpec\ObjectBehavior;

class HaversineLocatorSpec extends ObjectBehavior
{
    function let(PostalCodeTransformer $transformer)
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

    function it_uses_the_haversine_formula_to_determine_the_closest_location_to_a_coordinates(PostalCodeTransformer $transformer)
    {
        $transformer->toCoordinates(PostalCode::US('08080'))->willReturn(Coordinates::fromLatLon(
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
            'email' => 'beverlyhills@example.com',
        ]);

        $this->closestToPostalCode(PostalCode::US('08080'), [$cherryHill, $beverlyHills], 100000)->shouldReturn($cherryHill);
    }

    function it_should_throw_an_exception_if_there_are_no_locations_within_range(PostalCodeTransformer $transformer)
    {
        $transformer->toCoordinates(PostalCode::US('08080'))->willReturn(Coordinates::fromLatLon(
            Latitude::fromString('39.766415'),
            Longitude::fromString('-75.112302')
        ));

        $beverlyHills = Location::fromArray([
            'latitude' => '34.103003',
            'longitude' => '-118.410468',
            'email' => 'beverlyhills@example.com',
        ]);

        $this->shouldThrow(LocationOutOfRangeException::class)->duringClosestToPostalCode(PostalCode::US('08080'), [$beverlyHills], 1000);
    }

    function it_should_throw_an_exception_if_the_center_coordinates_cant_be_determined(PostalCodeTransformer $transformer)
    {
        $transformer->toCoordinates(PostalCode::US('99999'))->willThrow(UnknownCoordinatesException::class);

        $cherryHill = Location::fromArray([
            'latitude' => '39.881709',
            'longitude' => '-74.955948',
            'email' => 'cherryhill@example.com',
        ]);
        $beverlyHills = Location::fromArray([
            'latitude' => '34.103003',
            'longitude' => '-118.410468',
            'email' => 'beverlyhills@example.com',
        ]);

        $this->shouldThrow(UnknownCoordinatesException::class)->duringClosestToPostalCode(PostalCode::US('99999'), [$cherryHill, $beverlyHills], 100000);
    }
}
