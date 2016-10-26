<?php

namespace spec\Fortunato\Geomail\Geolocation;

use Fortunato\Geomail\Geolocation\Coordinates;
use Fortunato\Geomail\Geolocation\HaversineLocator;
use Fortunato\Geomail\Geolocation\Latitude;
use Fortunato\Geomail\Geolocation\Location;
use Fortunato\Geomail\Geolocation\Locator;
use Fortunato\Geomail\Geolocation\Longitude;
use Fortunato\Geomail\Geolocation\ZipTransformer;
use Fortunato\Geomail\Zip;
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

        $this->closestToZip(Zip::fromString('08080'), [$cherryHill, $beverlyHills])->shouldReturn($cherryHill);
    }
}
